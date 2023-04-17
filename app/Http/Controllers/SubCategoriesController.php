<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use App\Models\Sub_category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SubCategoriesController extends Controller
{



    public function api_index(){
        $categories=Sub_category::select('id', 'name')->
        withCount('properties')->get();
        return response()->json($categories, 200,);
    }




    public function api_index_v2(){
        $validator = Validator::make(['sell_type_id'=>request('sell_type_id')],
         [
            'sell_type_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid Sale ID'], 400);
        }
        $categories=Sub_category::select('id', 'name')->
        withCount([
            'properties'=>function ($query) {
                $query->where('sell_type_id', request('sell_type_id'));
            }
            ])

        ->get();
        return response()->json($categories, 200,);
    }

    public function api_update( $id)
    {
        if (!Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'Only admins can update Categories.',
            ], 403);
        }

        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'The ID must be an integer.'
            ], 422);
        }
        $category = Sub_category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'category not found.'
            ], 404);
        }
        $validator = Validator::make(request()->all(), [
            'name' => [
                'required',
                'max:255',
                Rule::unique('licences', 'name')->ignore($category->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors()
            ], 422);
        }



        $category->name = request()->input('name');
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully.',
            'data' => $category
        ]);
    }

    public function api_store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if (!Auth::user()->isAdmin) {
            return response()->json(['error' => 'You do not have permission to perform this action'], 403);
        }

        $category = new Sub_category;
        $category->name = $request->input('name');
        $category->save();

        return response()->json(['message' => 'Category has been saved successfully'], 200);
    }

    public function api_destroy($id) {
        $validator = Validator::make(['id' => $id], ['id' => 'required|integer']);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid category ID'], 400);
        }

        if (!Auth::user()->isAdmin) {
            return response()->json(['error' => 'You do not have permission to perform this action'], 403);
        }

        $category = Sub_category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'The category has been deleted'], 200);
    }
    public function api_getByCategory($id) {
        $validator = Validator::make(['id' => $id], ['id' => 'required|integer']);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid category ID'], 400);
        }

        $category = Sub_category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $properties = $category->properties;
        return response()->json(['properties' => $properties], 200);
    }
    public function api_getByCategory_v2($id) {
        $validator = Validator::make(['id' => $id,'sale_type_id'=>request('sale_type_id')],
         [
            'id' => 'required|integer',
            'sale_type_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid category Or Sale ID'], 400);
        }

        $category = Sub_category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $properties = $category->properties()->where('sell_type_id', request('sale_type_id'))->get();

        return response()->json(['properties' => $properties], 200);
    }




}
