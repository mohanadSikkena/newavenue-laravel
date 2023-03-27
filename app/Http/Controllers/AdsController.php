<?php

namespace App\Http\Controllers;

use App\Models\AdProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller
{
    public function api_ads()
    {
        try {
            $properties = AdProperty::all();
            return response()->json(['success' => true, 'data' => $properties], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function api_delete_ad($id)
    {
        try {
            if (!Auth::user()->isAdmin) {
                throw new \Exception('You do not have permission to perform this action.');
            }

            $property = AdProperty::findOrFail($id);

            if (Storage::exists($property->cover_image)) {
                Storage::delete($property->cover_image);
            }

            $property->delete();

            return response()->json(['success' => true, 'message' => 'AD Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function api_add_ad(Request $request)
    {
        try {
            if (!Auth::user()->isAdmin) {
                throw new \Exception('You do not have permission to perform this action.');
            }

            $request->validate([
                'end_date' => 'required',
                'property_id' => 'required|integer',
                'cover_image' => 'image',
            ]);

            $adProperty = new AdProperty;
            $adProperty->end_date = $request->input('end_date');
            $adProperty->property_id = $request->input('property_id');

            if ($request->hasFile('cover_image')) {
                $img = $request->file('cover_image');
                $name = $img->store('public/properties/ad_images');
                $adProperty->cover_image = $name;
            }

            $adProperty->save();

            return response()->json(['success' => true, 'message' => 'AD added successfully', 'data' => $adProperty], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
