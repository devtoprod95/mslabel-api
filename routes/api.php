<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

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

Route::name('v1.')->prefix('v1')->group(function () {
    Route::middleware(['jwt.verify'])->group(function () {
        Route::post('/token/create', [AuthController::class, 'tokenCreate'])->name('token.create');
        
        Route::get('/main', [MainController::class, 'list'])->name('main.list');

        /**
         * 관리자
         * 
        */
        Route::name('admin.')->prefix('admin')->group(function () {
            

        });


    });
});
