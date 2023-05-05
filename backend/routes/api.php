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
Route::post('/user/register', [AvaController::class, 'createUser'])->middleware('jwt.auth');
Route::put('/user/edit', [AvaController::class, 'editAUser'])->middleware('jwt.auth');
Route::delete('/user/delete', [AvaController::class, 'deleteAUser'])->middleware('jwt.auth');
Route::get('/user', [AvaController::class, 'getAUser'])->middleware('jwt.auth');

use App\Http\Controllers\ClientsController;
Route::get('/clients/show', [ClientsController::class, 'getClients'])->middleware('jwt.auth');
Route::post('/client/register', [ClientsController::class, 'createClients'])->middleware('jwt.auth');
Route::put('/client/edit', [ClientsController::class, 'editAClient'])->middleware('jwt.auth');
Route::delete('/client/delete', [ClientsController::class, 'deleteAClient'])->middleware('jwt.auth');
Route::get('/clients/options', [ClientsController::class, 'getClientsOptions'])->middleware('jwt.auth');
Route::get('/client', [ClientsController::class, 'getAClient'])->middleware('jwt.auth');

use App\Http\Controllers\ProductsController;
Route::get('/products/show', [ProductsController::class, 'getProducts'])->middleware('jwt.auth');
Route::post('/product/register', [ProductsController::class, 'createProduct'])->middleware('jwt.auth');
Route::put('/product/edit', [ProductsController::class, 'editAProduct'])->middleware('jwt.auth');
Route::delete('/product/delete', [ProductsController::class, 'deleteAProduct'])->middleware('jwt.auth');
Route::get('/products/options', [ProductsController::class, 'getProductsOptions'])->middleware('jwt.auth');
Route::get('/product', [ProductsController::class, 'getAProduct'])->middleware('jwt.auth');

use App\Http\Controllers\PurchasesController;
Route::get('/purchases/show', [PurchasesController::class, 'getPurchases'])->middleware('jwt.auth');
Route::post('/purchase/register', [PurchasesController::class, 'createPurchase'])->middleware('jwt.auth');
Route::put('/purchase/edit', [PurchasesController::class, 'editAPurchase'])->middleware('jwt.auth');
Route::delete('/purchase/delete', [PurchasesController::class, 'deleteAPurchase'])->middleware('jwt.auth');
Route::get('/purchase', [PurchasesController::class, 'getAPurchase'])->middleware('jwt.auth');

use App\Http\Controllers\ComandasController;
Route::get('/comandas/show', [ComandasController::class, 'getComandas'])->middleware('jwt.auth');
Route::post('/comanda/register', [ComandasController::class, 'createComanda'])->middleware('jwt.auth');
Route::delete('/comanda/delete', [ComandasController::class, 'deleteAComanda'])->middleware('jwt.auth');
Route::put('/comanda/edit', [ComandasController::class, 'editAComanda'])->middleware('jwt.auth');
Route::get('/comanda', [ComandasController::class, 'getAComanda'])->middleware('jwt.auth');

use App\Http\Controllers\CashRegisterController;
Route::get('/cashregister/show', [CashRegisterController::class, 'getCashRegisterToLeft'])->middleware('jwt.auth');
Route::post('/cashregister/register', [CashRegisterController::class, 'createCashRegister'])->middleware('jwt.auth');

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'getDashBoard'])->middleware('jwt.auth');
