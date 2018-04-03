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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/toplist', 'ToplistController@index')->name('toplist');

Route::get('/impressum', function()
{
    return Redirect::to('https://9d6.de/impressum.html');
})->name('impressum');

Route::get('/map', 'MapController@index')->name('map');

Route::get('/station/graph/{id}', 'GraphController@somedata')->name('graph.somedata');

Route::get('/station/find', 'StationController@find')->name('station.find');

Route::get('/station', 'StationController@index')->name('station.index');

Route::get('/station/{id}', 'StationController@show')->name('station.detail');

Route::get('/station/{id}/{date}', 'StationController@showdate')->name('station.detaildate');
