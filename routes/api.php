<?php

use App\Http\Controllers\PingController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('ping', [PingController::class, 'ping'])
    ->withoutMiddleware([Authenticate::class])
    ->name('ping');
