<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Mix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
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
Route::post('/getuser', [ClientController::class, 'returnUser']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/CarUser/{id}', [VehicleController::class, 'CarUSer']);
    Route::get('/BikeUser/{id}', [VehicleController::class, 'BikeUSer']);
    Route::post('/CAR',[VehicleController::class,'RegisterCar']);
    Route::post('/BIKE',[VehicleController::class,'RegisterBike']);
    
    Route::get('/clients', [ClientController::class, 'show'])->middleware(CheckRole::class . ':admin');
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

//creacion de long polling
Route::get('/entity/{id}', function ($id) {
    $entity = User::find($id);
    $status = $entity->active;
    $attemps=1;
    while ($status == 0 && $attemps<5) {
        sleep(2);

        $status= $entity->refresh()->active;
        $attemps++;
        
    }


    return response()->json($entity);
});