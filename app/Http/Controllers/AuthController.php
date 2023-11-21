<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use tidy;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Client::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ],400);
        }

        if ($user->active==0) {
            return response()-> json([
                'error' => 'Please activate your account'
            ],400);
          
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'id'=>$user->id,    
        ],200
);
       
    }
    public function logout(Request $request)

    {
       
        if (Auth::check()) {
            $request->user()->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Successfully logged out']);
    }

    
    public function active(Request $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json([
                'error' => 'Invalid credentials'
            ],400);
        }
        if ($request->activation_code !== $client->activation_code) {
            return response()->json([
                'error' => 'Invalid activation code'
            ],400);
        }
    
        $client->active = 1;
        $client->save();
        return response()->json([
            'message' => 'Successfully activated user!',
            'user' => $client
        ],200);
        
    }

    public function role(Request $request)
    {
        $user = $request->user();
        return response()->json($user->role);
    }
    
}
