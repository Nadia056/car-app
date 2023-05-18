<?php

use App\Events\MessageEvent;
use App\Events\SSEEvent;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\crud8Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('confirm/{id}', [ClientController::class,'confirm'])->name('confirm');

Route::get('/stream-books', [crud8Controller::class, 'streamBooks']);

Route::get('/sse', function () {
    $message = 'Sample message';

    Event::dispatch(new SSEEvent($message));
    return response()->json(['message' => $message]);
});

Route::post('/websocket/message', [WebSocketController::class, 'handleMessage']);

Route::get('/DIOS', function () {
    $message = 'DIOS';

    Event::dispatch(new MessageEvent($message));
    return response()->json(['message' => $message]);
});