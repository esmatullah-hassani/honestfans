<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('presence-video-channel-{id}', function($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('message-sent-{user_2}-{user_1}', function ($user) {
return Auth::check();
});

Broadcast::channel("life-channel",function($user){
    return Auth::check();
});

