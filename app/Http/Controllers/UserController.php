<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected function register(Request $request) : object{
        $fields = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
                'device_name' => 'required|string',
            ],
        );
        if($fields->fails()) {
            return response()->json($fields);
        }

        $fields = $fields->validated();
        $fields['password'] = bcrypt($fields['password']);

        try {
            $user = User::create($fields);
            $token = $user->createToken($fields['device_name'])->plainTextToken;

            $user['token'] = $token;
            $user['token_expiration'] = Carbon::now()->addMinutes(
                intval(
                    config('sanctum.expiration'),
                ),
            );

            $response = [
                'user' => $user,
            ];
            return response()->json($response, 201);

        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
            
    }

    protected function login(Request $request) : object{
        $fields = $request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string',
                'device_name' => 'required|string',
            ],
        );
        $user = User::where('email', $fields['email'])->first();

        if($user && Hash::check($fields['password'], $user->password)) {
            $user->tokens()->delete();

            $token = $user->createToken($fields['device_name'])->plainTextToken;

            $user['token'] = $token;
            $user['token_expiration'] = Carbon::now()->addSeconds(
                intval(
                    config('sanctum.expiration'),
                ),
            );

            $response = [
                'user' => $user,
            ];
            return response()->json($response, 201);
        }

        return response()->json(['error' => 'incorrect login credentials'], 401); 
    }
}
