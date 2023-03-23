<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;

class FeaturesController extends Controller
{
    // public function __construct(){
    //     $this->middleware(['auth']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    //     $features=Feature::all();
    //     return view('features.list', compact('features'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    //     return view('features.new');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //

    //     $feature=new Feature;
    //     $feature->name=$request->name;
    //     $feature->save();

    //     return redirect()->route('features.index');
    // }

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
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }

    public function api_index(){
        $features=Feature::all();
        return response()->json($features, 200,);
    }
    public function api_store(){
        if(Auth::user()->isAdmin){
            $feature =new Feature;
        $feature->name=request("name");
        $feature->save();
        return response()->json("A Feature Has Been Added Successfully", 200,);
        }
    }
    public function api_destroy($id){
        $feature=Feature::find($id);
        if(Auth::user()->isAdmin){
            $feature->delete();
        return response()->json('A Feature Has been Deleted Successfully', 200,);
        }
    }


}
