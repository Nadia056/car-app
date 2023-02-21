<?php

namespace App\Http\Controllers;

use App\Jobs\SendActivationCode;
use App\Jobs\SendMail;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function show()
    {
        $client = Client::all();
        return response()->json(['clientes'=>$client]);

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|min:10'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'active' => false,
            'phone' => $request->phone,
            'activation_code' => random_int(1000, 9999)
        ]);

        $client->save();
        $random=$client->activation_code;
        $url = URL::temporarySignedRoute(
            'confirm',
            now()->addMinute(5),
            ['id' => $client->id]
        );
        SendActivationCode::dispatch($client, $url,$random)
            ->delay(now()->addSeconds(10))
            ->onqueue('emailcodigo');
        SendMail::dispatch($client,$random)
            ->delay(now()->addSeconds(10))
            ->onqueue('emailcodigo');

        return response()->json([
            'message' => 'Successfully created user!',
            'validacion'=>'Active your account you will recive and email and a phone '

        ], 201);
    }
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->update($request->all());
        return response()->json($client);
    }
    public function delete(Request $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json('not found');
        }
        $client->delete($request->all());
        return response()->json('deleted');
    }
    public function confirm(Request $request,$id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json('not found');
        }
        $client->active = true;
        $client->save();
        return response()->json('confirmed');
    }
    public function showOne($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json('not found');
        }
        return response()->json(['cliente'=>$client]);
    }
}
