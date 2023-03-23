<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Customer;
use App\Models\CustomerProperty;
use App\Models\CustomerPropertyImage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class CustomersController extends Controller
{
    //


    public function api_create_customer(){
        $customer=new Customer;
        $customer->save();
        return response()->json($customer, 200,);


    }



    public function api_add_to_favourite(){
        $result =DB::table('customer_property')
        ->where('customer_id',request('customer_id'))
        ->where('property_id',request('property_id'))->get();

        if(count($result)==0){
            DB::table('customer_property')->insert([
                'customer_id'=>request('customer_id'),
                'property_id'=>request('property_id')
            ]);
            return response()->json('added to favourite ', 200,);
        }
        if(count($result)==1){

            DB::table('customer_property')
            ->where('customer_id',request('customer_id'))
            ->where('property_id',request('property_id'))->delete();



            return response()->json('removed from favourite favourite ', 200,);


        }


    }


    public function api_add_customer_property(Request $request){
        $customerProperty=new CustomerProperty;
        $customerProperty->name=request('name');
        $customerProperty->phone=request('phone');
        $customerProperty->save();
        return response()->json('added successfully', 200, );


    }

    public function api_getcustomers_properties(){
        if (Auth::user()->isAdmin){
            $properties=CustomerProperty::all();
            return response()->json($properties, 200, );
        }
        return response()->json('you dont have the permission', 200,);
    }

    public function api_delete_customer_property($id){
        if(Auth::user()->isAdmin){
            $property =CustomerProperty::find($id);
            $property->delete();
            return response()->json('deleted successfully', 200,);
        }
        return response()->json('you dont have the access to delete this', 200,);

    }



    public function api_customer_favourite($id){
        $customer=Customer::with("favourite:id,location,price")->find($id);
        return response()->json($customer, 200,);
    }
}
