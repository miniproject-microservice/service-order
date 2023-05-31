<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index () {
        $product = Product::all();
        return response()->json($product);
    }

    public function detail ($id) {
        $product = Product::find($id);
        if(!$product) return response()->json(["error" => true,"message" => "Product data not found"]);
        return response()->json($product);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataCreate = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ];

        try {
            Product::create($dataCreate);
        } catch (\Throwable $th) {
            //return $th;
            return response()->json(['message' => 'Create data failed']);
        }
        return response()->json(['message' => 'new product has been created']);
    }

    public function update ($id, Request $request) {
        $checkData = Product::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Product data not found"]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataUpdate = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ];

        try {
            Product::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update data failed']);
        }
        return response()->json(['message' => 'Product has been updated']);
    }

    public function delete($id)
    {   
        $checkData = Product::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Product data not found"]);
        
        try {
            Product::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Delete data failed']);
        }
        return response()->json(['message' => 'Product has been deleted']);
    }
}
