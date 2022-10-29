<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversionsController;
use App\Http\Controllers\UserController;

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

Route::controller(ConversionsController::class)->group(function() {
    Route::get('/', 'create')->name('index');
    // Route::post('/convert', 'store')->name('convert');
});

// Route::controller(UserController::class)->group(function(){
//     Route::get('/user/{action}', 'create')->where('action', 'register|login');
//     Route::post('/userProcessRequest', 'store');    
// });
