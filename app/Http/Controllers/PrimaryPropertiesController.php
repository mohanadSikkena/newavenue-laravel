<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\PrimaryProperty;
use App\Models\Primary_image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class PrimaryPropertiesController extends Controller
{
    //

    public function api_show($id){
        $property =PrimaryProperty::with('images:image,primary_property_id')
        ->with('location:name,id')
        ->with('primary_type:name,id')
        ->find($id);

        $similarProperties=$property->similarProperties();
        $property->similarProperties=$similarProperties;
        return response()->json($property, 200);
    }
    public function api_index(){
        $properties=PrimaryProperty::
        with('images:primary_property_id,image')->with('location:name,id')
        ->with('primary_type:name,id')->get();
        return response()->json($properties, 200,);
    }
    public function api_store(Request $request)
{
    // Check if user is admin
    if(!Auth::user()->isAdmin) {
        return response()->json("You don't have the permission to add primary", 403);
    }

    // Validate request
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'delivery_date' => 'required',
        'down_payment' => 'required',
        'min_price' => 'required',
        'max_price' => 'required',
        'min_total_price' => 'required',
        'min_Installment' => 'required',
        'Maintnance' => 'required',
        'min_space' => 'required',
        'max_space' => 'required',
        'location_id' => 'required|exists:locations,id',
        'primary_type_id' => 'required|exists:primary_types,id',
        'images.*' => 'required|image|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create new primary property
    $property = new PrimaryProperty;
    $property->name = $request->input('name');
    $property->min_price = $request->input('min_price');
    $property->max_price = $request->input('max_price');
    $property->min_total_price = $request->input('min_total_price');
    $property->min_Installment = $request->input('min_Installment');
    // $property->Gross = $request->input('Gross');
    $property->Maintnance = $request->input('Maintnance');
    $property->primary_type_id = $request->input('primary_type_id');
    $property->delivery_date = $request->input('delivery_date');
    $property->down_payment = $request->input('down_payment');
    // $property->developer_name = $request->input('developer_name');
    // $property->address = $request->input('address');
    $property->min_space = $request->input('min_space');
    $property->max_space = $request->input('max_space');
    // $property->price = $request->input('price');
    $property->location_id = $request->input('location_id');
    $property->save();

    // Save images
    if($request->hasFile('images')) {
        foreach($request->file('images') as $img) {
            $name = $img->store('images/primary_images');
            $image = new Primary_image;
            $image->image = $name;
            $image->primary_property_id = $property->id;
            $image->save();
        }
    }

    return response()->json([
        'message' => 'Property has been saved successfully',
        'data' => $property
    ], 201);
}

    public function api_destroy($id)
    {
        try {
            // Check if the authenticated user is an admin
            if (!Auth::user()->isAdmin) {
                throw new \Exception('You do not have the permission to delete this property', 403);
            }

            // Find the property by ID
            $property = PrimaryProperty::find($id);

            // Check if the property exists
            if (!$property) {
                throw new \Exception('The property does not exist', 404);
            }

            // Delete the property's images from storage
            foreach ($property->images as $image) {
                Storage::delete($image->image);
            }

            // Delete the property
            $property->delete();

            // Return a success response with a custom message
            return response()->json(['message' => 'The property has been deleted'], 200);
        } catch (\Exception $e) {
            // Return an error response with a custom message and status code
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }


}
