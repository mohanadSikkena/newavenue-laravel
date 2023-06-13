<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPropertyImage;
use App\Models\CustomerRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class CustomersController extends Controller
{
    public function api_create_customer()
    {
        $customer = new Customer;
        $customer->save();

        return response()->json([
            'message' => 'Customer created successfully',
            'data' => $customer
        ], 200);
    }

    public function api_add_to_favourite()
    {
        $customer_id = request('customer_id');
        $property_id = request('property_id');

        $customer = Customer::find($customer_id);
        $property = Property::find($property_id);
        if (!$customer || !$property) {
            return response()->json([
                'error' => [
                    'message' => 'Either the customer or the property was not found in the database.',
                ],
            ], 404);

        }
        $result = DB::table('customer_property')
            ->where('customer_id', $customer_id)
            ->where('property_id', $property_id)
            ->get();

        if (count($result) === 0) {
            DB::table('customer_property')->insert([
                'customer_id' => $customer_id,
                'property_id' => $property_id
            ]);

            return response()->json([
                'message' => 'Property added to favourites',
            ], 200);
        }else{
            DB::table('customer_property')
                ->where('customer_id', $customer_id)
                ->where('property_id', $property_id)
                ->delete();

            return response()->json([
                'message' => 'Property removed from favourites',
            ], 200);
        }


    }

    public function api_add_customer_property(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:191',
        'phone' => 'required|string|max:20',
    ], [
        'name.required' => 'The name is required.',
        'name.string' => 'The name must be a string.',
        'name.max' => 'The name must not exceed 191 characters.',
        'phone.required' => 'The phone number is required.',
        'phone.string' => 'The phone number must be a string.',
        'phone.max' => 'The phone number must not exceed 20 characters.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors()
        ], 422);
    }

    $customerProperty = new CustomerRequest;
    $customerProperty->name = $request->input('name');
    $customerProperty->phone = $request->input('phone');
    $customerProperty->save();

    return response()->json([
        'message' => 'Property added successfully',
        'data' => $customerProperty
    ], 200);
}


    public function api_getcustomers_properties()
    {
        if (Auth::user()->isAdmin) {
            $properties = CustomerRequest::all();

            return response()->json([
                'data' => $properties
            ], 200);
        }

        return response()->json([
            'error' => 'You do not have permission to perform this action'
        ], 403);
    }

    public function api_delete_customer_property($id)
    {
        if (Auth::user()->isAdmin) {
            $property = CustomerRequest::find($id);

            if (!$property) {
                return response()->json([
                    'error' => 'Property not found'
                ], 404);
            }

            $property->delete();

            return response()->json([
                'message' => 'Property deleted successfully'
            ], 200);
        }

        return response()->json([
            'error' => 'You do not have permission to perform this action'
        ], 403);
    }

    public function api_customer_favourite($id)
    {
        $customer = Customer::with("favourite:id,location,price")->find($id);

        if (!$customer) {
            return response()->json([
                'error' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'data' => $customer->favourite
        ], 200);
    }
}
