<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MenuController;
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
    Route::post('/token/create', [AuthController::class, 'tokenCreate'])->name('token.create');

    Route::middleware(['jwt.verify'])->group(function () {

        Route::name('admin.')->prefix('admin')->group(function () {
            Route::get('/main', [MainController::class, 'list'])->name('main.list');

            /** 메뉴 관련 */
            Route::name('menu.')->prefix('menu')->group(function () {
                Route::name('main.')->prefix('main')->group(function () {
                    /** 대표 메뉴 리스트 */
                    Route::get("/", [MenuController::class, "mainList"])->name("mainList");
                    /** 대표 메뉴 수정 */
                    Route::patch("/edit/{id}", [MenuController::class, "mainEdit"])->name("mainEdit");
                });

                Route::name('sub.')->prefix('sub')->group(function () {
                    /** 서브 메뉴 리스트 */
                    Route::get("/", [MenuController::class, "subList"])->name("subList");
                    /** 서브 메뉴 추가 */
                    Route::post("/create", [MenuController::class, "subMenuCreate"])->name("subMenuCreate");
                    /** 서브 메뉴 수정 */
                    Route::patch("/edit/{id}", [MenuController::class, "subEdit"])->name("subEdit");
                    /** 서브 메뉴 삭제 */
                    Route::delete("/delete/{id}", [MenuController::class, "subDelete"])->name("subDelete");
                });
            });
        });
    });
});
