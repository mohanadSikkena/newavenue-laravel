<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class LocationsController extends Controller
{
    //

    public function api_index(){
        $locations=Location::all();
        return response()->json($locations, 200,);
    }
    public function api_store(){
        if(Auth::user()->isAdmin){
            $location = new Location;
            $location->name=request("name");
            $location->save();
            return response()->json("location has been saved successfully", 200,);

        }
    }
    public function api_destroy($id) {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Bad Request', 'message' => 'The ID parameter must be a valid number.'], 400);
        }

        $location = Location::find($id);

        if (!$location) {
            return response()->json(['error' => 'Not Found', 'message' => 'The location does not exist.'], 404);
        }

        if (!Auth::user()->isAdmin) {
            return response()->json(['error' => 'Forbidden', 'message' => 'You do not have permission to delete this location.'], 403);
        }

        $location->delete();

        return response()->json(['message' => 'The location has been deleted successfully.'], 200);
    }



    public function api_primary($id){
        $location =Location::find($id);
        return response()->json($location->primary, 200,);
    }
}
