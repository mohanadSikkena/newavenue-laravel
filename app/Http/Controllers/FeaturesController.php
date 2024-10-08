<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FeaturesController extends Controller
{
    public function api_index()
    {
        $features = Feature::select('name','id')->get();
        return response()->json([
            'message' => 'Features retrieved successfully.',
            'data' => $features
        ]);
    }

    public function api_store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can create features.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:features,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $feature = new Feature;
        $feature->name = $request->input('name');
        $feature->save();

        return response()->json([
            'message' => 'Feature created successfully.',
            'data' => $feature
        ], 201);
    }

    public function api_destroy($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can delete features.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }

        $feature = Feature::find($id);

        if (!$feature) {
            return response()->json([
                'message' => 'Feature not found.'
            ], 404);
        }

        $feature->delete();

        return response()->json([
            'message' => 'Feature deleted successfully.'
        ]);
    }

    public function api_update( $id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can update features.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }
        $feature = Feature::find($id);

        if (!$feature) {
            return response()->json([
                'message' => 'feature not found.'
            ], 404);
        }
        $validator = Validator::make(request()->all(), [
            'name' => [
                'required',
                'max:255',
                Rule::unique('features', 'name')->ignore($feature->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }



        $feature->name = request()->input('name');
        $feature->save();

        return response()->json([
            'message' => 'Feature updated successfully.',
            'data' => $feature
        ]);
    }
}
