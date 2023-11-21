<?php

namespace App\Http\Controllers;

use App\Events\GameEnded;
use App\Events\TICEvent;
use App\Models\Client;
use App\Models\GameTic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TicController extends Controller
{

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
        if (Client::where('email', $request->email)->first()) {
            return response()->json(401);
        }
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'active' => true,
            'phone' => $request->phone,
            'activation_code' => random_int(1000, 9999)
        ]);

        $client->save();



        return response()->json(201);
    }
    public function join(Request $request)
    {
        $user = $request->id;

        $this->emitSSE('join', $user);
        $response = [
            'event' => 'join',
            'data' => $user
        ];
        $dataArray = Session::get('dataArray', []);

        // Append the new data to the array
        $dataArray[] = $user;

        // Store the updated array in the session
        Session::put('dataArray', $dataArray);


        $this->emitSSE($response['event'], $response['data']);
        return json_encode($dataArray);
    }

    private $board = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];

    public function moves(Request $request)
    {
        $board = $request->board;
        $player = $request->player;
        $response = [
            'event' => 'UPDATE_BOARD',
            'player' => $player,
            'data' => $board
        ];

        // Enviar evento SSE
        $this->WS($response['event'], $response);

        return response()->json($board);

    }

    private $moves = []; // Historial de movimientos

    public function board()
    {
        return $this->board;
    }

    public function move(Request $request)
    {
        $player = $request->input('player');
        $position = $request->input('position');

        // Obtener el tablero y los movimientos almacenados de la sesión
        $board = Session::get('board', [
            ['', '', ''],
            ['', '', ''],
            ['', '', '']
        ]);
        $movements = Session::get('movements', []);

        // Actualizar el tablero con el movimiento actual
        $board[$position[0]][$position[1]] = $player;

        // Agregar el movimiento al registro de movimientos
        $movements[] = [
            'player' => $player,
            'position' => $position
        ];

        // Guardar el tablero y los movimientos actualizados en la sesión
        Session::put('board', $board);
        Session::put('movements', $movements);

        // Actualizar el historial de movimientos de la clase
        $this->moves = $movements;

        // Emitir el evento SSE
        $response = [
            'event' => 'move',
            'data' => $board
        ];
        $this->emitSSE($response['event'], $response);

        // Devolver el tablero actualizado
        return response()->json($board);
    }


    public function user(Request $request)
    {
        $user = $request->user()->id;
        return $user;
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
}
