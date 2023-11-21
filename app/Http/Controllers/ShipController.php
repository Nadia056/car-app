<?php

namespace App\Http\Controllers;

use App\Events\ShipEvent;
use App\Models\CardShip;
use App\Models\Client;
use App\Models\ShipModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ShipController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255 | unique:clients',
            'password' => 'required|string',

        ]);

        
        if (Client::where('email', $request->email)->first()) {
            return response()->json(401);
        }
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'active' => true,
            'activation_code' => random_int(1000, 9999)
        ]);

        $client->save();



        return response()->json(201);
    }
    private $contador = 0;
    public function JOIN(Request $request)
    {
        $existingShip = ShipModel::where('player_id', $request->player_id)
            ->where('game_id', 1)
            ->first();
    
        if ($existingShip) {
            return response()->json('Player already exists in the game.', 200);
        }
    
        $ship = ShipModel::create([
            'player_id' => $request->player_id,
            'game_id' => 1 
        ]);
    
        $response = [
            'event' => 'jugadores',
            'data' => $ship
        ];
    
        // Emit event through WebSockets
        $this->WS($response['event'], $response);
    
        return response()->json('Player joined successfully.', 200);
    }
    public function choseCard(Request $request)
    {
        //solo guardar si el id del jugador no existe
        $existingShip = CardShip::where('player_id', $request->player_id)->first();

        if ($existingShip) {
            return response()->json('Player already exists in the game.', 200);
        }


        $client = CardShip::create([
            'player_id' => $request->player_id,
            'game_id' => 1,
            'card_id' => $request->card_id
            
        ]);

        $response = [
            'event' => 'carta escogida',
            'data' => $client
        ];
        $this->WS($response['event'], $response);
        return response()->json('Card chosen successfully.', 200);
        
    }
    

    public function cardDelete(Request $request, $id)
    {
        $card = CardShip::where('player_id', $id)->first();
        if ($card) {
            $card->delete();
        }
    
        $card2 = ShipModel::where('player_id', $id)->first();
        if ($card2) {
            $card2->delete();
        }
    
        $numeroCartas = ShipModel::count();
        $response = [
            'event' => 'numero de cartas',
            'data' => $numeroCartas
        ];
        $this->WS($response['event'], $response);
        return response()->json('Card deleted successfully.', 200);
    }
    
      
    

    
    public function OrderCard()
    {
        // Retrieve the sorted card IDs
        $cardIds = CardShip::orderBy('card_id', 'asc')->pluck('player_id')->toArray();
    
        $response = [
            'event' => 'cartas ordenadas',
            'data' => $cardIds
        ];
    
        $this->WS($response['event'], $response);
    
        return $cardIds;
    }

    
    public function getPlayers()
    {
        $numeroCartas= ShipModel::count();
        $response = [
            'event' => 'numero de cartas',
            'data' => $numeroCartas
        ];
        $this->WS($response['event'], $response);
    

    
        return $numeroCartas;

    }

    protected function WS($event, $data)
    {
        $response = [
            'event' => $event,
            'data' => $data
        ];


        // Enviar evento SSE
        event(new \App\Events\TICEvent(json_encode($response)));
    }
    protected function WS2($event, $data)
    {
        $response = [
            'event' => $event,
            'data' => $data
        ];


        // Enviar evento SSE
        event(new \App\Events\ShipEvent(json_encode($response)));
    }
}
