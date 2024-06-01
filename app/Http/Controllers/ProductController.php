<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'message' => "Berhasil mendapatkan data produk",
            'product' => $products
        ], 200);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        return response()->json([
            'message' => "Berhasil mendapatkan data produk",
            'product' => $product
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'image' => ['required', 'file', 'image', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $product = new Product;
        $product->product_category_id = $request->input('product_category_id');
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $filename = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('', $filename);
        $product->image = $path;
        $product->save();
        return response()->json(['message' => 'Berhasil menambahkan data produk', 'product' => $product], 201);
    }

    public function update(int $id, Request $request)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        $validator = Validator::make($request->all(), [
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'file', 'image', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $product->product_category_id = $request->input('product_category_id');
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }
            $filename = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('', $filename);
            $product->image = $path;
        }
        $product->save();
        return response()->json(['message' => 'Berhasil mengubah data produk', 'product' => $product], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();
        return response()->json(['message' => 'Berhasil menghapus data produk'], 200);
    }
}
