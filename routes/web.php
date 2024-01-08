<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TodolistController;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'home']);
Route::view('/template', 'template');

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'login')->middleware(OnlyGuestMiddleware::class);
    Route::post('/login', 'processLogin')->middleware(OnlyGuestMiddleware::class);
    Route::post('/logout', 'processLogout')->middleware(OnlyMemberMiddleware::class);
});

Route::controller(TodolistController::class)->middleware(OnlyMemberMiddleware::class)->group(function() {
    Route::get('/todolist', 'todolist');
    Route::post('/todolist', 'addTodo');
    Route::post('/todolist/{id}/delete', 'removeTodo');
});