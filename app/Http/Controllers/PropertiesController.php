<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Sell_type;
use App\Models\Category;
use App\Models\Property_image;
use App\Models\Sub_category;
use App\Models\Property_detail;
use App\Models\AdProperty;

use Illuminate\Http\Request;
use Illuminate\Http\User;
use App\Models\Feature_property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PropertiesController extends Controller
{
    // public function __construct(){
    //     $this->middleware(['auth']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // //
        // $properties=Property::all();
        // return view('properties.list',compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $categories=Category::all();
        // $sellTypes=Sell_type::all();
        // $subCategories=Sub_category::all();
        // return view('properties.new',["categories"=>$categories , "sellTypes" =>$sellTypes ,"subCategories"=>$subCategories]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)


    {
        //

        // return redirect()->route('properties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function api_most_views(){
        $properties =Property::
        where('confirmed',true)
        ->with('images:image,property_id')
        ->with('features:name')
        ->with('agent:name,id,about,img,description')
        ->with('details:name,details,property_id')
        ->orderBy('views','desc')
        ->take(5)
        ->get();
        return response()->json($properties, 200,);

    }
    public function api_getPrimary(){
        $properties = Property::where('category_id',1)
        ->where('confirmed',true)
        ->with('images:image,property_id')
        ->with('features:name')
        ->with('agent:name,id,about,img,description')
        ->with('details:name,details,property_id')
        ->get();
        return response()->json($properties, 200,);
    }


    public function api_index(){
        if(request('sell_type')=="buy"){
            $properties =Property::where('sell_type_id',1)
            ->with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id,about,img,description')
            ->with('details:name,details,property_id')
            ->where('confirmed',true)
            ->paginate(10);
            $count=Property::where('sell_type_id',1)->where('confirmed',true)->count();
        }
        elseif(request('sell_type')=="rent"){
            $properties =Property::where('sell_type_id',2)
            ->with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id,about,img,description')
            ->with('details:name,details,property_id')
            ->where('confirmed',true)
            ->paginate(10);
            $count=Property::where('sell_type_id',2)->where('confirmed',true)->count();

        }
        else {
            $properties =Property::
            with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id,about,img,description')
            ->with('details:name,details,property_id')
            ->where('confirmed',true)
            ->paginate(10);

            $count=Property::where('confirmed',true)->count();

            // $properties =Property::all();
        }
        $response=["properties"=>$properties,"count"=>$count];
        return response()->json($response);
    }

    public function api_trash(){
        if(Auth::user()->isAdmin){
            $properties=Property::
            with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id')
            ->with('details:name,details,property_id')
            ->onlyTrashed()
            ->get();
            return response()->json($properties, 200, );
        }
        else{
            $properties=Property::
            where('agent_id',Auth::user()->id)
            ->with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id')
            ->with('details:name,details,property_id')
            ->onlyTrashed()

            ->get();
            return response()->json($properties, 200, );

        }
    }
    public function api_onHold(){

        if(Auth::user()->isAdmin){
            $properties =Property::
            with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id')
            ->with('details:name,details,property_id')

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

    public function api_store(Request $request){
        {
            //


            $property = new Property;
            $property->area=request("area");

            $property->description = request("description");


            $property->agent_id=Auth::user()->id;
            $property->sell_type_id = request("sellType");

            $property->category_id = request("category");

            $property->sub_category_id = request("subCategory");

            $property->location=request("location");

            $property->price=request("price");
            $property->save();



            if(request('features')!==null){
                foreach(request('features') as $feature ){
                DB::table('feature_property')->insert([
                    'feature_id'=>$feature,
                    'property_id'=>$property->id
                ]);



            }
            }

            if(request('details')!==null){
                foreach (request('details') as $detail) {
                $pro_detail=new Property_detail;


                $pro_detail->name=$detail['name'];
                $pro_detail->details=$detail['detail'];
                $pro_detail->property_id=$property->id;

                $pro_detail->save();
            }
            }
            if($request->hasFile('images')){
                foreach($request->file('images') as $img){

                $name=$img->store('public/properties');
                $image=new Property_image;
                $image->image=$name;
                $image->property_id=$property->id;
                $image->save();
            }

            }

            return response()->json('a property has been added', 200,);

        }

    }
//*************************************************************************** */

    public function api_update($id){

        $property=Property::find($id);

        if(Auth::user()->id==$property->agent_id || Auth::user()->isAdmin){
            $property->description=request('description');
            $property->sell_type_id=request('sellType');
            $property->category_id=request('category');
            $property->sub_category_id=request('subCategory');
            $property->save();

            return response()->json('updated successfully', 200);
        }
        return response()->json('you dont have the access to edit this property', 200);

    }
//*************************************************************************** */

    public function api_getByCategory(){
        if(request('category_id')!='' && request('sub_category_id')!=''){
            $properties= Property::
            where('category_id',request('category_id'))
            ->where('sub_category_id',request('sub_category_id'))
            ->with('images:property_id,image')
            ->with('details:property_id,name,details')
            ->with('features:name')
            ->with('agent:name,id,about,img,description')
            ->where('confirmed',true)
            ->get();

            return response()->json($properties, 200);
        }
        return response()->json('failed');

    }

    public function api_destroy($id){
        $property=Property::find($id);
        if(Auth::user()->isAdmin||Auth::user()->id==$property->agent_id){
            $property->delete();
        return response()->json('A Property Has been Deleted Successfully', 200,);
        }


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
        $property=Property::with('images:property_id,image')
        ->with('features:name')
        ->with('details:property_id,name,details')
        ->with('agent:name,id,about,img,description')
        ->find($id);
        $property->views+=1;
        $property->save();
        return response()->json($property, 200);
    }

    public function api_agent_prop($id){
        $properties=
        Property::where('agent_id',$id)
        ->where('confirmed',true)
        ->with('images:image,property_id')
        ->with('details:details,name,property_id')
        ->with('features:name')
        ->get();
        return response()->json($properties, 200,);
    }

    public function api_ads(){
        $properties=AdProperty::all();
        return response()->json($properties, 200);
    }


    public function api_delete_ad($id){
        if(Auth::user()->isAdmin){
            $property=AdProperty::find($id);
            Storage::delete($property->cover_image);
            $property->delete();
            return response()->json('AD Deleted Successfully', 200, );
        }

    }

    public function api_add_ad(Request $request){
        if(Auth::user()->isAdmin){
            $adProperty=new AdProperty;
            $adProperty->end_date=request('end_date');
            $adProperty->property_id=request('property_id');
            if($request->hasFile('cover_image')){
                $img=$request->file('cover_image');
                $name=$img->store('public/properties/ad_images');
                $adProperty->cover_image=$name;
            }

            $adProperty->save();
            return response()->json($adProperty, 200);



        }
        return response()->json('you dont have the permession', 200);
    }
    public function api_search(){
        $properties =Property::
            with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id,about,img,description')
            ->with('details:name,details,property_id')
            ->where('confirmed',true)
            ->where(function ($query){
                $term=request('word');
                $query->where('location','LIKE',"%$term%");
            })
            ->get();

            return response()->json($properties, 200);
    }

    public function api_filter(Request $request){
        if(request('from_search')){

            $properties =Property::
            with('images:image,property_id')
            ->with('features:name')
            ->with('agent:name,id,about,img,description')
            ->with('details:name,details,property_id')
            ->where('confirmed',true)
            ->where(function ($query){
                $term=request('word');
                $query->where('location','LIKE',"%$term%");
            })
            ->whereBetween('price',[request('min_price'), request('max_price')])
            ->whereBetween('area',[request('min_area',), request('max_area')])
            ->where('sell_type_id',request('sale_type'))
            ->where('category_id' , request('category'))
            ->get();
        }else{
            $properties= Property::
            where('category_id',request('category'))
            ->where('sub_category_id',request('sub_category_id'))
            ->with('images:property_id,image')
            ->with('details:property_id,name,details')
            ->with('features:name')
            ->with('agent:name,id,about,img,description')
            ->whereBetween('price',[request('min_price'), request('max_price')])
            ->whereBetween('area',[request('min_area',), request('max_area')])
            ->where('sell_type_id',request('sale_type'))
            ->where('confirmed',true)
            ->get();
        }
        return response()->json($properties, 200);
    }

}
