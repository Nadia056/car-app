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
            return response()->json(
                400
            );
        }

        if ($user->active==0) {
            return response()->json( 
                401
          );
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(
          $token,
            200  
        );
       
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
                'error' => 'Invalid activation code'
            ]);
        }
    
        $client->active = 1;
        $client->save();
        return response()->json([
            'message' => 'Successfully activated user!',
            'user' => $client
        ]);
        
    }

    public function role(Request $request)
    {
        $user = $request->user();
        return response()->json($user->role);
    }
    
}
