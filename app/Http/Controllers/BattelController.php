<?php

namespace App\Http\Controllers;

use App\Models\BattelModel;
use Illuminate\Http\Request;

class BattelController extends Controller
{
    public function cordenadas(Request $request)
    {
        $player_id = $request->player_id;
        $rowIndex = $request->rowIndex;
        $colIndex = $request->colIndex;
        $value = $request->value;
       

        $response = [
            'event' => 'cordenadas',
            'data' => [
                'player_id' => $player_id,
                'rowIndex' => $rowIndex,
                'colIndex' => $colIndex,
                'value' => $value,
            ]
        ];
        $this->WS('cordenadas', $response);
        return response()->json($response);


    }
    public function join(Request $request)
    {
        
            $existingShip = BattelModel::where('player_id', $request->player_id)
                ->where('game_id', $request->game_id)
                ->first();
        
            if ($existingShip) {
                return response()->json('Player already exists in the game.', 200);
            }
        
            $ship = BattelModel::create([
                'player_id' => $request->player_id,
                'game_id' => $request->game_id, 
            ]);
        
            $response = [
                'event' => 'jugadores',
                'data' => $ship
            ];
        
            // Emit event through WebSockets
            $this->WS($response['event'], $response);
        
            return response()->json('Waiting ', 200);
        
    }
    public function order()
    {
        $cardIds = BattelModel::orderBy('id', 'asc')->pluck('player_id')->toArray();
        
            $response = [
                'event' => 'cartas ordenadas',
                'data' => $cardIds
            ];
        
            $this->WS($response['event'], $response);
        
            return $cardIds;
        
    }
    protected function WS($event, $data)
    {
        $response = [
            'event' => $event,
            'data' => $data
        ];


        // Enviar evento SSE
        event(new \App\Events\BattelEvent(json_encode($response)));
    }

}
