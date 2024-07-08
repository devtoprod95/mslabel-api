<?php

use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
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
            /** 메인 관련 */
            Route::name('main.')->prefix('main')->group(function () {
                /** 상단 배너 리스트 */
                Route::get("/topBanners", [AdminMainController::class, "topBannersList"])->name("topBannersList");
                /** 상단 배너 등록 */
                Route::post("/topBanner/create", [AdminMainController::class, "topBannerCreate"])->name("topBannerCreate");
                /** 상단 배너 수정 */
                Route::post("/topBanner/edit/{id}", [AdminMainController::class, "topBannerEdit"])->name("topBannerEdit");
                /** 상단 배너 삭제 */
                Route::delete("/topBanner/delete/{id}", [AdminMainController::class, "topBannerDelete"])->name("topBannerDelete");
            });

            Route::get('/main', [MainController::class, 'list'])->name('main.list');

            /** 메뉴 관련 */
            Route::name('menu.')->prefix('menu')->group(function () {
                Route::name('main.')->prefix('main')->group(function () {
                    /** 대표 메뉴 리스트 */
                    Route::get("/", [AdminMenuController::class, "mainList"])->name("mainList");
                    /** 대표 메뉴 수정 */
                    Route::patch("/edit/{id}", [AdminMenuController::class, "mainEdit"])->name("mainEdit");
                });

                Route::name('sub.')->prefix('sub')->group(function () {
                    /** 서브 메뉴 리스트 */
                    Route::get("/", [AdminMenuController::class, "subList"])->name("subList");
                    /** 서브 메뉴 추가 */
                    Route::post("/create", [AdminMenuController::class, "subMenuCreate"])->name("subMenuCreate");
                    /** 서브 메뉴 수정 */
                    Route::patch("/edit/{id}", [AdminMenuController::class, "subEdit"])->name("subEdit");
                    /** 서브 메뉴 삭제 */
                    Route::delete("/delete/{id}", [AdminMenuController::class, "subDelete"])->name("subDelete");
                });
            });
        });
    });
});
