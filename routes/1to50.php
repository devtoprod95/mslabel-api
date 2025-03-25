<?php

use App\Http\Controllers\OneToFifty\ScoreController;
use Illuminate\Support\Facades\Route;

/** 기록 생성 */
Route::post("/create", [ScoreController::class, "create"])->name("create");