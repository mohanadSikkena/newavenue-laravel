<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Licence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class LicencesController extends Controller
{
    public function api_index()
    {
        $licences = Licence::all();
        return response()->json([
            'message' => 'Licences retrieved successfully.',
            'data' => $licences
        ]);
    }


    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can create licences.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:licences,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $licence = new Licence;
        $licence->name = $request->input('name');
        $licence->save();

        return response()->json([
            'message' => 'Licence created successfully.',
            'data' => $licence
        ], 201);
    }


    public function update( $id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can update licences.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }
        $licence = Licence::find($id);

        if (!$licence) {
            return response()->json([
                'message' => 'Licence not found.'
            ], 404);
        }
        $validator = Validator::make(request()->all(), [
            'name' => [
                'required',
                'max:255',
                Rule::unique('licences', 'name')->ignore($licence->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }



        $licence->name = request()->input('name');
        $licence->save();

        return response()->json([
            'message' => 'Licence updated successfully.',
            'data' => $licence
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can delete licences.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }

        $licence = Licence::find($id);

        if (!$licence) {
            return response()->json(['message' => 'Licence not found.'
        ], 404);
        }
        $licence->delete();

        return response()->json([
            'message' => 'Licence deleted successfully.',
        ]);
    }
}




