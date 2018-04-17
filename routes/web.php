<?php

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

Route::get('/', 'GuestController@index')->name('welcome');

Route::get('/impressum', function()
{
    return Redirect::to('https://9d6.de/impressum.html');
})->name('impressum');

/* all routes below need an account to show*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/toplist', 'ToplistController@index')->name('toplist');

Route::get('/map', 'MapController@index')->name('map');

/* ------------------- */
/* train routes */
/* helper routes*/
Route::get('/train/{trainclass}/{trainnumber}/stations', 'TrainController@stations')->name('train.detailstations');

Route::get('/train/{trainclass}/{trainnumber}/delay/graph', 'GraphController@getTrainDelayStatistic')->name('train.detaildelaygraph');

Route::get('/train/{trainclass}/{trainnumber}/delay', 'TrainController@delay')->name('train.detaildelay');

Route::get('/train/{trainclass}/{trainnumber}/cancel', 'TrainController@cancel')->name('train.detailcancel');

Route::get('/train/{trainclass}/{trainnumber}/platform', 'TrainController@platform')->name('train.detailplatform');

Route::get('/train/{trainclass}/{trainnumber}/route', 'TrainController@route')->name('train.detailroute');

Route::get('/train/find', 'TrainController@find')->name('train.find');

/* base routes*/
Route::get('/train/{trainclass}/{trainnumber}', 'TrainController@detail')->name('train.detail');

Route::get('/train', 'TrainController@index')->name('train.index');



/* ------------------- */
/* station routes*/
/* helper routes*/
Route::get('/station/graph/{id}', 'GraphController@somedata')->name('graph.somedata');




Route::get('/station/{id}/timetable/{date}', 'StationController@timetable')->name('station.detaildate');

Route::get('/station/{id}/train/{type}/{number}', 'GraphController@getTrainStatisticForStation')->name('graph.trainstatistik');

Route::get('/station/{id}/train', 'StationController@train')->name('station.detailzug');

Route::get('/station/{id}/trainperplatform/graph', 'GraphController@getTrainclassPerPlatformStatistic')->name('graph.trainperplatform');

Route::get('/station/{id}/trainperplatform', 'StationController@platform')->name('station.detailgleis');


Route::get('/station/find', 'StationController@find')->name('station.find');

/* base routes*/
Route::get('/station/{id}', 'StationController@detail')->name('station.detail');

Route::get('/station', 'StationController@index')->name('station.index');
