<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ApiController extends Controller
{
    public function getAllProducts() {
      $products = Product::get()->toJson(JSON_PRETTY_PRINT);
      return response($products, 200);
    }

    public function createProduct(Request $request) {
      $product = new Product;
      $product->name = $request->name;
      $product->price = $request->price;
      $product->save();

    return response()->json([
        "message" => "product record created"
    	], 201);
    }

    public function getProduct($id) {
      if (Product::where('id', $id)->exists()) {
        $product = Product::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($product, 200);
      } else {
        return response()->json([
          "message" => "Product not found"
        ], 404);
      }
    }

    public function updateProduct(Request $request, $id) {
      if (Product::where('id', $id)->exists()) {
        $product = Product::find($id);
        $product->name = is_null($request->name) ? $product->name : $request->name;
        $product->price = is_null($request->price) ? $product->price : $request->price;
        $product->save();

        return response()->json([
            "message" => "records updated successfully"
        ], 200);
        } else {
        return response()->json([
            "message" => "Product not found"
        ], 404);
        
    }
    }

    public function deleteProduct ($id){ 
      if(Product::where('id', $id)->exists()) {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Product not found"
        ], 404);
      }
    }
}

