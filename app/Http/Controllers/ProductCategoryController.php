<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all();

        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return response()->json(['message' => 'Product category not found'], 404);
        }

        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Save the product data
        $category = new ProductCategory;
        $category->name = $request->input('name');

        $category->save();

        return response()->json(['message' => 'Product category created successfully', 'category' => $category], 201);
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return response()->json(['message' => 'Product category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category->name = $request->input('name');

        $category->save();

        return response()->json(['message' => 'Product category updated successfully', 'category' => $category], 200);
    }

    public function destroy($id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return response()->json(['message' => 'Product category not found'], 404);
        }

        // Delete the product record from the database
        $category->delete();

        return response()->json(['message' => 'Product category deleted successfully'], 200);
    }
}
