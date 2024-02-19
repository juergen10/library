<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PretestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/pretest', [PretestController::class, 'index']);


Route::post('register', [AuthController::class, 'register']);
