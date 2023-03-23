<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finish;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FinishesController extends Controller
{
    public function api_index()
    {
        $finishes = Finish::all();
        return response()->json([
            'message' => 'Finishes retrieved successfully.',
            'data' => $finishes
        ]);
    }


    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can create finishes.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:finishes,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $finish = new Finish;
        $finish->name = $request->input('name');
        $finish->save();

        return response()->json([
            'message' => 'Finish created successfully.',
            'data' => $finish
        ], 201);
    }


    public function update($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can update finishes.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }
        $finish = Finish::find($id);

        if (!$finish) {
            return response()->json([
                'message' => 'Finish not found.'
            ], 404);
        }
        $validator = Validator::make(request()->all(), [
            'name' => [
                'required',
                'max:255',
                Rule::unique('finishes', 'name')->ignore($finish->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }



        $finish->name = request()->input('name');
        $finish->save();

        return response()->json([
            'message' => 'Finish updated successfully.',
            'data' => $finish
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can delete finishes.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }

        $finish = Finish::find($id);

        if (!$finish) {
            return response()->json(['message' => 'Finish not found.'
        ], 404);
        }
        $finish->delete();

        return response()->json([
            'message' => 'Finish deleted successfully.',
        ]);
    }
}

