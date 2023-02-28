<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Mix;
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

Route::post('/clients', [ClientController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/active/{id}', [AuthController::class, 'active']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/getuser', [ClientController::class, 'returnUser']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/clients/{id}', [ClientController::class, 'showOne'])->middleware(CheckRole::class . ':admin');
    Route::get('/clients', [ClientController::class, 'show'])->middleware(CheckRole::class . ':admin');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->middleware(CheckRole::class . ':admin');
    Route ::delete('/clients/{id}', [ClientController::class, 'delete'])->middleware(CheckRole::class . ':admin');
    Route::get('/allusers', [ClientController::class, 'Users'])->middleware(CheckRole::class . ':admin');
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/bikes', [BikeController::class, 'show'])->middleware(CheckRole::class . ':admin');
    Route::get('/bikes/{id}', [BikeController::class, 'showone']);
    Route::post('/bikes', [BikeController::class, 'store'])->middleware(CheckRole::class . ':admin');
    Route::put('/bikes/{id}', [BikeController::class, 'update'])->middleware(CheckRole::class . ':admin');
    Route::delete('/bikes/{id}', [BikeController::class, 'delete'])->middleware(CheckRole::class . ':admin');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cars', [CarController::class, 'show']);
    Route::get('/cars/{id}', [CarController::class, 'showone']);
    Route::post('/cars', [CarController::class, 'store'])->middleware(CheckRole::class . ':admin');
    Route::put('/cars/{id}', [CarController::class, 'update'])->middleware(CheckRole::class . ':admin');
    Route ::delete('/cars/{id}', [CarController::class, 'delete'])->middleware(CheckRole::class . ':admin');
});






