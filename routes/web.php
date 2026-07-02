<?php

use App\Http\Controllers\GraphController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\ToplistController;
use App\Http\Controllers\TrainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

Route::get('/', [GuestController::class, 'index'])->name('welcome');

Route::get('/impressum', function () {
    return Redirect::to('https://9d6.de/impressum.html');
})->name('impressum');

/* all routes below need an account to show */
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/toplist', [ToplistController::class, 'index'])->name('toplist');

Route::get('/map', [MapController::class, 'index'])->name('map');

/* ------------------- */
/* train routes */
/* helper routes */
Route::get('/train/{trainclass}/{trainnumber}/stations', [TrainController::class, 'stations'])->name('train.detailstations');

Route::get('/train/{trainclass}/{trainnumber}/delay', [TrainController::class, 'delay'])->name('train.detaildelay');

Route::get('/train/{trainclass}/{trainnumber}/cancel', [TrainController::class, 'cancel'])->name('train.detailcancel');

Route::get('/train/{trainclass}/{trainnumber}/platform', [TrainController::class, 'platform'])->name('train.detailplatform');

Route::get('/train/{trainclass}/{trainnumber}/route', [TrainController::class, 'route'])->name('train.detailroute');

Route::get('/train/find', [TrainController::class, 'find'])->name('train.find');

/* base routes */
Route::get('/train/{trainclass}/{trainnumber}', [TrainController::class, 'detail'])->name('train.detail');

Route::get('/train', [TrainController::class, 'index'])->name('train.index');

/* ------------------- */
/* station routes */
/* helper routes */
Route::get('/station/graph/{id}', [GraphController::class, 'somedata'])->name('graph.somedata');

Route::get('/station/{id}/timetable/{date}', [StationController::class, 'timetable'])->name('station.detaildate');

Route::get('/station/{id}/train/{type}/{number}', [GraphController::class, 'getTrainStatisticForStation'])->name('graph.trainstatistik');

Route::get('/station/{id}/train', [StationController::class, 'train'])->name('station.detailzug');

Route::get('/station/{id}/trainperplatform/graph', [GraphController::class, 'getTrainclassPerPlatformStatistic'])->name('graph.trainperplatform');

Route::get('/station/{id}/trainperplatform', [StationController::class, 'platform'])->name('station.detailgleis');

Route::get('/station/find', [StationController::class, 'find'])->name('station.find');

/* base routes */
Route::get('/station/{id}', [StationController::class, 'detail'])->name('station.detail');

Route::get('/station', [StationController::class, 'index'])->name('station.index');
