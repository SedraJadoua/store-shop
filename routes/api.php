<?php

use App\Http\Controllers\accountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\colorController;
use App\Http\Controllers\mangerController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\productController;
use App\Http\Controllers\productOrderController;
use App\Http\Controllers\storeController;
use App\Http\Controllers\typeController;
use App\Http\Controllers\userController;
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


Route::apiResource('account' , accountController::class)->only(['index' , 'destroy']);
Route::apiResource('color' , colorController::class);
Route::apiResource('manger' , mangerController::class);
Route::apiResource('user' , userController::class);
Route::apiResource('store' , storeController::class);
Route::apiResource('type' , typeController::class);
Route::apiResource('order' , orderController::class);
Route::apiResource('product' , productController::class);
Route::apiResource('productOrder' , productOrderController::class)->only(['index' , 'store']);;
Route::controller(storeController::class)->prefix('fun_store')->group(function (){
    Route::post('/unblockStore','unblockStore');
    Route::post('/blockStore','blockStore');
});

Route::controller(productController::class)->prefix('fun_product')->group(function (){
    Route::post('/updateproduct/{id}','update');
    Route::post('/typeIndex','typeIndex');
    Route::post('/search','search');
});
Route::controller(storeController::class)->prefix('store')->group(function (){
    Route::post('/storeupdate/{id}','update');
});

Route::controller(mangerController::class)->prefix('fun_manger')->group(function(){
    Route::post('blockManger', 'block');
    Route::post('acceptManger', 'accept');
    Route::get('Accepted', 'mangersAccepted');
});



Route::controller(AuthController::class)->prefix('auth')->group(function(){
    Route::post('register' , 'register');
    Route::post('logout' , 'logout');
    Route::get('profile' , 'profile');
    Route::post('login' , 'login');
    Route::post('update/{id}' , 'update');
    Route::post('loginEmail' , 'login_email');
    Route::post('loginUserName' , 'login_userName');
});
