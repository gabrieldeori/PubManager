<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\AuthController;
Route::post('/login', [AuthController::class, 'login']);

use App\Http\Controllers\AvaController;
Route::get('/users/show', [AvaController::class, 'getUsers']);
Route::get('/user', [AvaController::class, 'getAUser']);
Route::put('/user/edit', [AvaController::class, 'editAUser']);
Route::post('/user/register', [AvaController::class, 'createUser']);
Route::delete('/user/delete', [AvaController::class, 'deleteAUser']);

use App\Http\Controllers\ClientsController;
Route::get('/clients/show', [ClientsController::class, 'getClients']);
Route::get('/client', [ClientsController::class, 'getAClient']);
Route::put('/client/edit', [ClientsController::class, 'editAClient']);
Route::post('/client/register', [ClientsController::class, 'createClients']);
Route::delete('/client/delete', [ClientsController::class, 'deleteAClient']);
