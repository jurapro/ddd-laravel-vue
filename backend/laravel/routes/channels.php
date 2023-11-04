<?php

use Domain\Shared\Models\User\User;
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
    return (int)$user->id === (int)$id;
});

Broadcast::channel('channel.user.{id}', function (User $user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('channel', function (User $user) {
    return true;
});

Broadcast::channel('random', function (User $user) {
    return true;
});
