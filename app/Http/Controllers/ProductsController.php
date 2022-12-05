<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(), 
            [
                'title' => 'required|string|min:5',
                'description' => 'required|string|min:10',
                'amount' => 'required|min:1',
                'image' => 'required|string|min:10',
                'favorite' => 'required'
            ],
        );
        if($validator->fails()) {
            Log::warning('something went wrong');
            return response()->json($validator)->header('Content-type', 'application/json');
        }
        
        $data = $validator->validated();
        $query = false;
        try {
            $query = Products::create($data);
        } catch(\Exception $e) {
            Log::warning($e);
        }
        
        if($query) {
            return response()->json(['message' => 'success'])->header('Content-type', 'application/json');
        }
    }
}
