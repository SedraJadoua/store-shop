<?php

use App\Mail\MangerBlock;
use App\Models\account;
use App\Models\store;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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


Route::get('sendMail' , function(){
    Mail::to('sesejad2002xxx@gmail.com')->send(new MangerBlock());
});
Route::get('account' , function(){
  return    account::where('type' , 5)->get();

});
Route::get('image' , function(){
  return  store::first();

});