<?php

use App\Events\GameEnded;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BattelController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\crud7Controller;
use App\Http\Controllers\crud8Controller;
use App\Http\Controllers\crud9Controller;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\TicController;
use App\Http\Middleware\CheckRole;
use App\Models\GameTic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//practica3
Route::post('/practica3', [BikeController::class, 'store']);

//practica4
Route::post('/practica4', [CarController::class, 'store'])->middleware(['auth:sanctum', 'check.role:1,3']);
Route::get('/practica4', [CarController::class, 'show']);
Route ::delete('/practica4/{id}', [CarController::class, 'delete'])->middleware(['auth:sanctum', 'delete:1']);
Route::put('/practica4/{id}', [CarController::class, 'update'])->middleware(['auth:sanctum', 'check.role:1,3']);
//practica5
Route::post('/practica5', [ClientController::class, 'store']);

//practica 6
Route::post('/clients', [ClientController::class, 'store'])->middleware(['auth:sanctum', 'check.role:1,3']);
Route::get('/clients', [ClientController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/active/{id}', [AuthController::class, 'active']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/s',[ClientController::class,'index'])->middleware('auth:sanctum');
Route::put('/clients/{id}', [ClientController::class, 'update'])->middleware(['auth:sanctum', 'delete:1']);


//practica 7
Route::post('/practica7', [crud7Controller::class, 'store']);
Route::get('/practica7', [crud7Controller::class, 'index']);
Route ::delete('/practica7/{id}', [crud7Controller::class, 'delete']);
Route::put('/practica7/{id}', [crud7Controller::class, 'update']);


//practica 8
Route::get('practica8', [crud8Controller::class, 'index']);
Route::get('practica8B/{id}', [crud8Controller::class, 'book']);
Route::post('practica8', [crud8Controller::class, 'store']);
Route::put('practica8/{id}', [crud8Controller::class, 'update']);
Route::delete('practica8/{id}', [crud8Controller::class, 'destroy']);
Route::get('event-source', [crud8Controller::class, 'eventSource']);

//practica 9 
Route::post('/practica9', [crud9Controller::class, 'store']);
Route::get('/practica9',[crud9Controller::class,'index']);
Route::delete('/practica9/{id}', [crud9Controller::class, 'delete']);
Route::put('/practica9/{id}', [crud9Controller::class, 'update']);

//practica 10 Tic Tac Toe
Route::post('/practica10', [TicController::class, 'store']);
Route::post('/join', [TicController::class, 'join']);
Route::get('/board', [TicController::class, 'board']);
Route::get('/new', [TicController::class, 'handelBoard']);
Route::post('/move', [TicController::class, 'move']);
Route::post('/moves', [TicController::class, 'moves']);
Route::get('/user', [TicController::class, 'user'])->middleware('auth:sanctum');
Route::post('/practica10/reset', [TicController::class, 'resetGame']);


//practica 11 BattelShip
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/P11/join',[BattelController::class,'join']);
Route::get('/P11/order',[BattelController::class,'order']);
Route::post('/P11/coordenadas',[BattelController::class,'cordenadas']);


//practica 12 ship 
Route::post('/P12/register',[ShipController::class,'store']);
Route::post('/P12/join',[ShipController::class,'JOIN']);
Route::get('/P12/players',[ShipController::class,'getPlayers']);
Route::post('/P12/choose',[ShipController::class,'choseCard']);
Route::get('/P12/order',[ShipController::class,'OrderCard']);
Route::delete('/P12/delete/{id}',[ShipController::class,'cardDelete']);







