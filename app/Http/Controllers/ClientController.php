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
        return $client;

    }
    public function index(Request $request)
    {
        $user = $request->user();
        return $user;
    }   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255 | unique:clients',
            'password' => 'required|string|confirmed',
            'phone' => 'required|string|min:10'

        ]);
        
        if ($request->password != $request->password_confirmation) {
            return response()->json(400);
        }
        if(Client::where('email',$request->email)->first()){
            return response()->json(401);
        }
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
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
            ->delay(now()->addSeconds(1))
            ->onqueue('emailcodigo');
        // SendMail::dispatch($client,$random)
        //     ->delay(now()->addSeconds(1))
        //     ->onqueue('emailcodigo');

        return response()->json( 201);
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
        return response()->json($client);
    }
    //returna el id 
    public function returnUser(Request $request)
    {
        $client = Client::where('email', $request->email)->first();
        if (!$client) {
            return response()->json('not found');
        }
        return response()->json(['id'=>$client->id]);
    }
    public function Users()
    {
        $client=Client::all();
        return response()->json($client);
    }



}
