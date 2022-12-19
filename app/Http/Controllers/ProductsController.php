<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    private array $productFields = [
        'title' => 'required|string|min:5',
        'description' => 'required|string|min:10',
        'amount' => 'required|min:1',
        'image' => 'required|string|min:10',
    ];

    protected function store(Request $request) : object {
        $validator = Validator::make(
            $request->all(), 
            $this->productFields,
        );
        if($validator->fails()) {
            return response()->json($validator);
        }
        
        $data = $validator->validated();
        try {
            $query = Products::create($data);
            if($query) {
                return response()->json($query);
            }
        } catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    protected function fetch(Request $request) : object {
        $header = $request->header();
        if(array_key_exists('user', $header) && $header['user'][0] == 'true') {    
            $products = Products::where('user_id', auth()->user()->id)->get();
        } else {
            $products = Products::all();
        }
        return response()->json($products);
    }
    
    protected function delete(Request $request) : object {
        try {
            $query = Products::find($request->id)->delete();
            if($query) {
                return response()->json($query);
            }
            return response()->setStatusCode(403);
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 403);
        }
    }

    protected function patch(Request $request) : object {
        $query = Products::find($request->id)->update(
            [
                'favorite' => $request->favorite,
            ],
        );
        if($query) {
            return response()->json($query);
        }
        return response()->setStatusCode(403);
    }

    protected function update(Request $request) : object {
        $product = Products::find($request->id)->get();
        if($product == null) {
            return response()->json($product);
        }

        $validator = Validator::make(
            $request->all(), 
            $this->productFields,
        );
        if($validator->fails()) {
            return response()->json($validator);
        }
        
        $data = $validator->validated();
        try {
            $query = Products::where('id', $request->id)->update($data);
            if($query) {
                return response()->json($query);
            }
        } catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
