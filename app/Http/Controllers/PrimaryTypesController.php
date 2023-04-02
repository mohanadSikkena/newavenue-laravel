<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrimaryType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrimaryTypesController extends Controller
{
    public function api_index()
    {
        $primaryTypes = PrimaryType::select('name','id')->get();
        return response()->json([
            'message' => 'Primary types retrieved successfully.',
            'data' => $primaryTypes
        ]);
    }

    public function api_store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can create primary types.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191|unique:primary_types,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $primaryType = new PrimaryType;
        $primaryType->name = $request->input('name');
        $primaryType->save();

        return response()->json([
            'message' => 'Primary type created successfully.',
            'data' => $primaryType
        ], 201);
    }

    public function api_update($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can update primary types.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }

        $primaryType = PrimaryType::find($id);

        if (!$primaryType) {
            return response()->json([
                'message' => 'Primary type not found.'
            ], 404);
        }

        $validator = Validator::make(request()->all(), [
            'name' => [
                'required',
                'max:191',
                Rule::unique('primary_types', 'name')->ignore($primaryType->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $primaryType->name = request()->input('name');
        $primaryType->save();

        return response()->json([
            'message' => 'Primary type updated successfully.',
            'data' => $primaryType
        ]);
    }

    public function api_destroy($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can delete primary types.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }

        $primaryType = PrimaryType::find($id);

        if (!$primaryType) {
            return response()->json([
                'message' => 'Primary type not found.'
            ], 404);
        }

        $primaryType->delete();

        return response()->json([
            'message' => 'Primary type deleted successfully.',
        ]);
    }
}
