<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\PrimaryProperty;
use App\Models\Primary_image;
use Illuminate\Support\Facades\Storage;


class PrimaryPropertiesController extends Controller
{
    //

    public function api_show($id){
        $property =PrimaryProperty::with('images:image,primary_property_id')
        ->with('location:name,id')
        ->find($id);
        return response()->json($property, 200);
    }
    public function api_index(){
        $properties=PrimaryProperty::
        with('images:primary_property_id,image')->get();
        return response()->json($properties, 200,);
    }
    public function api_store(Request $request){
        if(Auth::user()->isAdmin){
            $property=new PrimaryProperty;
        $property->name=request('name');
        $property->delivery_date=request('delivery_date');
        $property->payment_plan=request('payment_plan');
        $property->developer_name=request('developer_name');
        $property->address=request('address');
        $property->min_space=request('min_space');
        $property->max_space=request('max_space');
        $property->price=request('price');
        $property->location_id=request('location_id');
        $property->save();

        if($request->hasFile('images')){
            foreach($request->file('images') as $img){

            $name=$img->store('public/primary');
            $image=new Primary_image;
            $image->image=$name;
            $image->primary_property_id=$property->id;
            $image->save();
        }

        }
        return response()->json("property has been saved", 200,);
        }
        return response()->json("you dont have the permission to add primary", 200, );
    }
    public function api_destroy($id){
        if(Auth::user()->isAdmin){
            $property=PrimaryProperty::find($id);
            foreach($property->images as $image){
                Storage::delete($image->image);
            }
            $property->delete();
            return response()->json("a property has been deleted", 200, );

        }
        return response()->json("you ddont have the permission", 200,);
    }
}
