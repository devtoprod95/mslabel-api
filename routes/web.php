<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->noContent(200);
});

Route::get('/test', function() {
    return '
        <script>
            // JavaScript를 사용하여 페이지를 리디렉션
            window.open("http://localhost:8090/phpmyadmin/");
        </script>
    ';
});