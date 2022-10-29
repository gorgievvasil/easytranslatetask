<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Create user to use for API requests
    public function createUser(Request $request) {        
        try{
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8',
                    'confirm_password' => 'required|same:password'
                ]
            );

            // invalid user data
            if($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'User validation error',
                        'errors' => $validateUser->errors()
                    ], 
                    200
                );
            }

            // valid user data
            $user = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]
            );

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User created successfully',
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200
            );
        }
        catch(\Throwable $t) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $t->getMessage()
                ], 500
            );
        }
    }

    // Login existing user
    public function loginUser(Request $request) {
        try {
            // validate login request
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'password' => 'required'
                ]
            );

            if($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Validation error',
                        'error' => $validateUser->errors()
                    ], 
                    200
                );
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Invalid email or password'
                    ], 401
                );
            }

            $user = User::where('email', $request->email)->first();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User login successful',
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200
            );
        }
        catch(\Throwable $t)
        {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'User login failed. Error: ' . $t->getMessage()
                ], 
                500
            );
        }
    }
}
