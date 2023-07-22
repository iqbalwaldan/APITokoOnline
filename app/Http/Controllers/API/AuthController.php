<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email','password'])))
        {
            return response()->json([
                'status' => 'Error has occured...',
                'message' => 'Credentials do not match',
                'data' => ''
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => 'Request was succesful',
            'message' => null,
            'data' => [
                'user' =>$user, 
                'token' => $user->createToken("API Token of " . $user->name)->plainTextToken
            ]
        ], 200);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role_id' => 2
        ]);

        return response()->json([
            'status' => 'Request was succesful',
            'message' => null,
            'data' => [
                'user' =>$user, 
                'token' => $user->createToken("API Token of " . $user->name)->plainTextToken
            ]
        ], 200);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'Request was succesful',
            'message' => 'You have successfully been logged out.',
        ], 200);
    }
}
