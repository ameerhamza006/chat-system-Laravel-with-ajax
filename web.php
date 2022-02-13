<?php

use App\Http\Controllers\Admin\ChatController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/chat',[ChatController::class,'chat'])->name('chat');
Route::post('/chatsend',[ChatController::class,'chatsend'])->name('chat.send');
Route::get('/chatall',[ChatController::class,'chatall'])->name('chat.all');
