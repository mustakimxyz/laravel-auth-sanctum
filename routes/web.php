<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Symfony\Component\HttpFoundation\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::post('/login',  [AuthController::class, 'generateToken']);
    Route::post('/register', [AuthController::class, 'registerAndGenerateToken']);
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
        return $request->user();
    });
    Route::get('/list',  [UserController::class, 'index']);
});
