<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreetController;

Route::get('/', function () {
    return 'Hello laravel!';
});

Route::get('/greet', [GreetController::class,'greet']);

