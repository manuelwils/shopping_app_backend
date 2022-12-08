<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    protected function store(Request $request) : object {
        return response()->json($request->all());
        $validator = Validator::make(
            $request->all(), 
            [
                'title' => 'required|string|min:5',
                'amount' => 'required|string|min:1',
                'products' => 'required|min:1',
                'quantity' => 'required|string|min:1',
            ],
        );
        if($validator->fails()) {
            return response()->json($validator);
        }
        
        $data = $validator->validated();
        try {
            $query = Orders::create($data);
            if($query) {
                return response()->json($query);
            }
        } catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    protected function fetch() : object {
        $products = Orders::all();
        return response()->json($products);
    }

    protected function delete(Request $request) : object {
        try {
            $query = Orders::find($request->id)->delete();
            if($query) {
                return response()->json($query);
            }
            return response()->setStatusCode(403);
        } catch(\Exception $e) {
            return Log::warning($e);
        }
    }
}
