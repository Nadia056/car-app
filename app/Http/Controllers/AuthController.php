<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Client::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ]);
        }

        if ($user->active==0) {
            return response()->json([
                'error' => 'Your account is not activated yet. Please check your email to activate your account.'
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
       
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->Client()->currentAccessToken()->delete();
        }
    
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function active(Request $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json([
                'error' => 'Invalid credentials'
            ]);
        }
        if ($request->activation_code !== $client->activation_code) {
            return response()->json([
                'error' => 'Invalid credentials'
            ]);
        }
    
        $client->active = 1;
        $client->save();
        return response()->json([
            'message' => 'Successfully activated user!',
            'user' => $client
        ]);
    }
    
}
