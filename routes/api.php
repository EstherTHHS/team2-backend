<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\SubscribeController;
use App\Http\Controllers\API\UserController;

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


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('/users', UserController::class);

});

Route::apiResource('/items', ItemController::class);
Route::apiResource('/subscribe-payment', SubscribeController::class);

Route::post('/subscribe-payment/{userId}', [SubscribeController::class,'subscribePayment']);

Route::delete('delete/item-image/{id}', [ItemController::class, 'deleteItemImage']);
Route::get('item/category/{category}', [ItemController::class, 'getItemByCategory']);
Route::post('/users/{id}/status', [UserController::class, 'userStatus']);

Route::post('auth/register', [UserController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/social/login', [UserController::class, 'socialLogin']);
