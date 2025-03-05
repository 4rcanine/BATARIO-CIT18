<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GreetController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return 'Hello laravel!';
});

Route::get('/greet', [GreetController::class,'greet']);

Route::resource('tasker', TaskController::class);
