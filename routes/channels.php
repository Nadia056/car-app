<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('sse-channel', function ($user) {
    return true;
});
Broadcast::channel('battel-game', function ($user) {
  return true;
});

Broadcast::channel('channel-game', function ($user) {
  return true;
});
Broadcast::channel('ship-game', function ($user) {
    return true;
  });

Broadcast::channel('sse-move', function () {
    return true; 
});



