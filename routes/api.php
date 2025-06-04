<?php

use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SmsController;
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

    Route::post('/sms/login', [SmsController::class, 'login'])->name('sms.login');

    Route::middleware(['jwt.verify'])->group(function () {

        Route::name('admin.')->prefix('admin')->group(function () {
            /** 메인 관련 */
            Route::name('main.')->prefix('main')->group(function () {

                /** 상단 배너 관련 */
                Route::name('topBanners.')->prefix('topBanners')->group(function () {
                    /** 상단 배너 리스트 */
                    Route::get("/", [AdminMainController::class, "topBannersList"])->name("list");
                    /** 상단 배너 등록 */
                    Route::post("/create", [AdminMainController::class, "topBannerCreate"])->name("create");
                    /** 상단 배너 수정 */
                    Route::post("/edit/{id}", [AdminMainController::class, "topBannerEdit"])->name("edit");
                    /** 상단 배너 삭제 */
                    Route::delete("/delete/{id}", [AdminMainController::class, "topBannerDelete"])->name("delete");
                });

                /** 소개 관련 */
                Route::name('intro.')->prefix('intro')->group(function () {
                    /** 소개 리스트 */
                    Route::get("/", [AdminMainController::class, "introList"])->name("list");
                    /** 소개 등록 */
                    Route::post("/create", [AdminMainController::class, "introCreate"])->name("create");
                    /** 소개 수정 */
                    Route::post("/edit/{id}", [AdminMainController::class, "introEdit"])->name("edit");
                    /** 소개 삭제 */
                    Route::delete("/delete/{id}", [AdminMainController::class, "introDelete"])->name("delete");
                });

                /** 소개2 관련 */
                Route::name('intro2.')->prefix('intro2')->group(function () {
                    /** 소개 리스트 */
                    Route::get("/", [AdminMainController::class, "intro2List"])->name("list");
                    /** 소개 등록 */
                    Route::post("/create", [AdminMainController::class, "intro2Create"])->name("create");
                    /** 소개 수정 */
                    Route::post("/edit/{id}", [AdminMainController::class, "intro2Edit"])->name("edit");
                    /** 소개 삭제 */
                    Route::delete("/delete/{id}", [AdminMainController::class, "intro2Delete"])->name("delete");
                });


            });

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

            /** 게시글 관련 */
            Route::name('board.')->prefix('board')->group(function () {
                Route::name('{type}.')->prefix('{type}')->group(function () {
                    /** 게시판 리스트 */
                    Route::get("", [BoardController::class, "list"])->name("list");
                    /** 게시판 상세 */
                    Route::get("/{id}", [BoardController::class, "detail"])->name("detail");
                    /** 게시판 생성 */
                    Route::post("/create", [BoardController::class, "create"])->name("create");
                    /** 게시판 수정 */
                    Route::post("/edit/{id}", [BoardController::class, "edit"])->name("edit");
                    /** 게시판 삭제 */
                    Route::delete("/delete/{id}", [BoardController::class, "delete"])->name("delete");
                });

                /** 게시판 유형 답변 등록 */
                Route::post("/reply/{id}", [BoardController::class, "reply"])->name("reply");
            });
        });
    });
});

Route::prefix("1to50")->name("1to50.")->group(base_path("routes/1to50.php"));