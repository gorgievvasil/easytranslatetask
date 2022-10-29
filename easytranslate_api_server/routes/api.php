<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiConversionsController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('convert/{source_currency}/{target_currency}/{amount}', [ApiConversionsController::class, 'conversion']);
// Route::controller(ApiConversionsController::class)->group(function() {
//     Route::get
// });

// Route::post('/auth/register', [AuthController::class, 'createUser']);
// Route::post('/auth/login', [AuthController::class, 'loginUser']);

// Route::controller(AuthController::class)
//     ->group(function(){
//         Route::post('auth/register', 'createUser');
//         Route::post('auth/login', 'loginUser');
//     });

// Route::post('register', 'AuthController@createUser')->name('registerUser');conver

Route::prefix('auth')->name('auth.')
    ->group(function(){
        Route::post('/register', [AuthController::class, 'createUser'])->name('register');
        Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
    });

Route::prefix('conversion')->middleware('auth:sanctum')->name('conversion.')
    ->group(function() {
        Route::post('/', [ApiConversionsController::class, 'store'])->name('store');
        Route::get('/rate', [ApiConversionsController::class, 'getRate'])->name('rate');
        Route::get('/currencies', [ApiConversionsController::class, 'getCurrencies'])->name('currencies');
    });