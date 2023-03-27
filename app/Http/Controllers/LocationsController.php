<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LocationsController extends Controller
{
    public function api_index()
    {
        $locations = Location::withCount('primary')->get();
        return response()->json([
            'message' => 'Locations retrieved successfully.',
            'data' => $locations

        ]);
    }

    public function api_store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can create locations.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191|unique:locations,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $location = new Location;
        $location->name = $request->input('name');
        $location->save();

        return response()->json([
            'message' => 'Location created successfully.',
            'data' => $location
        ], 201);
    }

    public function api_update($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can update locations.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'message' => 'Location not found.'
            ], 404);
        }

        $validator = Validator::make(request()->all(), [
            'name' => [
                'required',
                'max:255',
                Rule::unique('locations', 'name')->ignore($location->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $location->name = request()->input('name');
        $location->save();

        return response()->json([
            'message' => 'Location updated successfully.',
            'data' => $location
        ]);
    }

    public function api_destroy($id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can delete locations.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }

        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'message' => 'Location not found.'
            ], 404);
        }

        $location->delete();

        return response()->json([
            'message' => 'Location deleted successfully.',
        ]);
    }

    public function api_primary($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'message' => 'Location not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Primary location retrieved successfully.',
            'data' => $location->primary,
        ]);
    }
}
