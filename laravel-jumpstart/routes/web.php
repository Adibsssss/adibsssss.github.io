<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;


Route::get('/hello', function () {
    return view('welcome');
});

Route::get('/hello', [HelloController::class, 'greet']);