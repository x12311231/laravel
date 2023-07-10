<?php

use \Illuminate\Support\Facades\Route;

Route::get('/vue', function () {
    return layout('vue');
});
