<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalcController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/start', function () {
    return view('start');
});

Route::get('/calculator', function () {
    return view('calculator');
});


Route::get('/result', function () {
    return view('result');
});

Route::post('/calculator', [CalcController::class,'calculator']);
Route::post('/result', [CalcController::class,'result']);
