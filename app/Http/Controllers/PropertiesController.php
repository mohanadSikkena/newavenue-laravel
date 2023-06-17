<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Sell_type;
use App\Models\Category;
use App\Models\Property_image;
use App\Models\Sub_category;
use App\Models\Property_detail;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Http\User;
use App\Models\Feature_property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PropertiesController extends Controller
{




    public function api_most_views(){
        $properties =Property::withCommonReleations()

        ->where('confirmed',true)

        ->orderBy('views','desc')
        ->take(5)
        ->get();
        return response()->json($properties, 200,);

    }



    public function api_index(){
        $validSellTypes=['buy','rent'];
        $sellType = request('sell_type');
        if(!in_array($sellType, $validSellTypes)) {
            return response()->json(['error' => 'Invalid sell type'], 400);
        }
        $query = Property::withCommonReleations()->where('confirmed', true);

        if ($sellType == 'buy') {
            $query->where('sell_type_id', 1);
        } elseif ($sellType == 'rent') {
            $query->where('sell_type_id', 2);
        }
        $properties = $query->paginate(10);
        $count = $query->count();
        $response=[
            "properties" => $properties,
            "count" => $count,
        ];
        return response()->json($response,200);
    }
    public function api_index_v2(){

        $query = Property::withCommonReleations()->latest()->where('confirmed', true);
        $properties = $query->paginate(10);
        $count = $query->count();
        $response=[
            "properties" => $properties,
            "count" => $count,
        ];
        return response()->json($response,200);
    }

    public function api_trash(){
        if(Auth::user()->isAdmin){
            $properties=Property::
            withCommonReleations()
            ->onlyTrashed()
            ->get();
            return response()->json($properties, 200, );
        }
        else{
            $properties=Property::
            withCommonReleations()
            ->where('agent_id',Auth::user()->id)

            ->onlyTrashed()

            ->get();
            return response()->json($properties, 200, );

        }
    }
    public function api_onHold(){

        if(Auth::user()->isAdmin){
            $properties =Property::
            withCommonReleations()
            ->where('confirmed',false)
            ->get();
            return response()->json($properties);
        }
        return response()->json('you dont have the access', 200, );

    }
    public function api_accept($id){
       if(Auth::user()->isAdmin)
        {
        $property=Property::find($id);
        $property->confirmed=1;
        $property->save();
        return response()->json('a property accepted successfully', 200, );
       }
       return response()->json('you dont have the permission', 200, );

    }

    public function api_reject($id){
        if(Auth::user()->isAdmin)
        {
        $property=Property::find($id);
        foreach ($property->images as $image) {
            Storage::delete($image->image);
        }
        $property->forceDelete();
        return response()->json('a property rejected successfully', 200, );
        }
        return response()->json('you dont have the permission', 200, );
    }

//*************************************************************************** */

    public function api_store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'area' => 'required',
            'licence' => 'required',
            'finish' => 'required',
            'description' => 'required',
            'sellType' => 'required',
            'subCategory' => 'required',
            'location' => 'required',
            'price' => 'required',
            'features' => 'array',
            'details' => 'array',
            'images' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }

        $property = new Property;
        $property->area = $request->input('area');
        $property->licence_id = $request->input('licence');
        $property->finish_id = $request->input('finish');
        $property->description = $request->input('description');
        $property->agent_id = Auth::user()->id;
        $property->sell_type_id = $request->input('sellType');
        $property->sub_category_id = $request->input('subCategory');
        $property->location = $request->input('location');
        $property->price = $request->input('price');
        $property->save();

        if ($request->has('features')) {
            foreach ($request->input('features') as $feature) {
                DB::table('feature_property')->insert([
                    'feature_id' => $feature,
                    'property_id' => $property->id
                ]);
            }
        }

        if ($request->has('details')) {
            foreach ($request->input('details') as $detail) {
                $pro_detail = new Property_detail;
                $pro_detail->name = $detail['name'];
                $pro_detail->details = $detail['detail'];
                $pro_detail->property_id = $property->id;
                $pro_detail->save();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = $img->store('images/properties_images');
                $image = new Property_image;
                $image->image = $name;
                $image->property_id = $property->id;
                $image->save();
            }
        }

        return response()->json([
            'message' => 'A property has been added successfully.',
            'data' => $property
        ], 201);
    }

//*************************************************************************** */

    public function api_update($id){

        $property=Property::find($id);

        if(Auth::user()->id==$property->agent_id || Auth::user()->isAdmin){
            $property->description=request('description');
            $property->sell_type_id=request('sellType');
            $property->sub_category_id=request('subCategory');
            $property->save();

            return response()->json('updated successfully', 200);
        }
        return response()->json('you dont have the access to edit this property', 200);

    }
//*************************************************************************** */



    public function api_destroy($id)
    {
        // Validate the ID parameter
        if (!is_numeric($id)) {
            return response()->json('Invalid ID parameter.', 400);
        }

        // Retrieve the property
        $property = Property::find($id);

        // Validate if the property exists
        if (!$property) {
            return response()->json('Property not found.', 404);
        }

        // Verify the user is authorized to delete the property
        if (!Auth::user()->isAdmin && Auth::user()->id != $property->agent_id) {
            return response()->json('Unauthorized.', 401);
        }

        // Delete the property
        $property->delete();

        // Return a success message
        return response()->json('Property deleted successfully.', 200);
    }


    public function api_restore($id){
        $property=Property::onlyTrashed()->find($id);

        if(Auth::user()->isAdmin||Auth::user()->id==$property->agent_id){
            $property->restore();
        return response()->json('A Property Restored Successfully', 200,);
        }



    }

    public function api_hardDelete($id){
        $property=Property::onlyTrashed()->find($id);
        if(isset($property)){
            if(Auth::user()->isAdmin||Auth::user()->id==$property->agent_id){
                foreach ($property->images as $image) {
                    Storage::delete($image->image);
                }
                $property->forceDelete();

                return response()->json('A Property Has been Deleted Forever Successfully', 200,);
            }
        }
        return response()->json('Failed To Delete Property', 200,);

    }

    public function api_show($id){
        $property=Property::withCommonReleations()
        ->find($id);
        $property->views+=1;
        $property->save();
        $similarProperties = $property->similarProperties();
        $property->similarProperties=$similarProperties;
        return response()->json($property, 200);
    }

    public function api_agent_prop($id){
        $properties=
        Property::
        withCommonReleations()
        ->where('agent_id',$id)
        ->where('confirmed',true)
        ->get();
        return response()->json($properties, 200,);
    }







    public function api_search(){
        $properties =Property::
            withCommonReleations()
            ->where('confirmed',true)
            ->where(function ($query){
                $term=request('word');
                $query->where('location','LIKE',"%$term%");
            })
            ->get();

            return response()->json($properties, 200);
    }


}
