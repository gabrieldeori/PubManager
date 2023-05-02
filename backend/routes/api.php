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

// Route::middleware('api')->get('/user', function (Request $request) {
//     return $request->user();
// });

use App\Http\Controllers\AuthController;
Route::post('/login', [AuthController::class, 'login']);
Route::post('/authorize', [AuthController::class, 'authorizeToken']);
Route::post('/logout', [AuthController::class, 'logout']);

use App\Http\Controllers\AvaController;
Route::get('/users/show', [AvaController::class, 'getUsers'])->middleware('jwt.auth');
Route::get('/user', [AvaController::class, 'getAUser'])->middleware('jwt.auth');
Route::put('/user/edit', [AvaController::class, 'editAUser'])->middleware('jwt.auth');
Route::post('/user/register', [AvaController::class, 'createUser'])->middleware('jwt.auth');
Route::delete('/user/delete', [AvaController::class, 'deleteAUser'])->middleware('jwt.auth');

use App\Http\Controllers\ClientsController;
Route::get('/clients/show', [ClientsController::class, 'getClients'])->middleware('jwt.auth');
Route::get('/client', [ClientsController::class, 'getAClient'])->middleware('jwt.auth');
Route::put('/client/edit', [ClientsController::class, 'editAClient'])->middleware('jwt.auth');
Route::post('/client/register', [ClientsController::class, 'createClients'])->middleware('jwt.auth');
Route::delete('/client/delete', [ClientsController::class, 'deleteAClient'])->middleware('jwt.auth');
