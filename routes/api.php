<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\crud7Controller;
use App\Http\Controllers\crud8Controller;
use App\Http\Controllers\crud9Controller;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//practica3
Route::post('/practica3', [BikeController::class, 'store']);

//practica4
Route::post('/practica4', [CarController::class, 'store']);
Route::get('/practica4', [CarController::class, 'show']);
Route ::delete('/practica4/{id}', [CarController::class, 'delete']);
Route::put('/practica4/{id}', [CarController::class, 'update']);

//practica5
Route::post('/practica5', [ClientController::class, 'store']);

//practica 6
Route::post('/clients', [ClientController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/active/{id}', [AuthController::class, 'active']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user',[ClientController::class,'index'])->middleware('auth:sanctum');
Route::put('/clients/{id}', [ClientController::class, 'update'])->middleware('auth:sanctum');


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

//practica 9 
Route::post('/practica9', [crud9Controller::class, 'store']);
Route::get('/practica9',[crud9Controller::class,'index']);
Route::delete('/practica9/{id}', [crud9Controller::class, 'delete']);
Route::put('/practica9/{id}', [crud9Controller::class, 'update']);





