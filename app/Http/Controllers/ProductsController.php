<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    protected function store(Request $request) : object {
        $validator = Validator::make(
            $request->all(), 
            [
                'title' => 'required|string|min:5',
                'description' => 'required|string|min:10',
                'amount' => 'required|min:1',
                'image' => 'required|string|min:10',
            ],
        );
        if($validator->fails()) {
            return response()->json($validator);
        }
        
        $data = $validator->validated();
        $query = false;
        try {
            $query = Products::create($data);
            if($query) {
                return response()->json($query);
            }
        } catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    protected function fetch() : object {
        $products = Products::all();
        return response()->json($products);
    }
}
