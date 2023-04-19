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

//Broadcast::channel('article.{author_id}', function ($user, $author_id) {
//    \Illuminate\Support\Facades\Log::debug('channel test');
//    return false;
//});
Broadcast::channel('article.{author_id}', function ($user, $author_id) {
    \Illuminate\Support\Facades\Log::debug('channel test');
    return ['test' => $author_id];
});

Broadcast::channel('private.article.{author_id}', function ($user, $author_id) {
    return true;
});

Broadcast::channel('room.{id}.join', function ($user, $id) {
    return ['user' => $user, 'id' => $id];
});
