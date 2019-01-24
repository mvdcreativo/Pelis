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

// Route::get('/', function () {
//      return view('movies.peliculas');




// });

Route::get('/scraping', 'ScrapingController@tomar_datos');
Route::get('/status-remote-upload', 'StatusController@getStatus');
Route::get('/serch-id-tmdb', 'ExternalIdController@cotejarIds');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/', 'MovieController');

Route::resource('peliculas', 'MovieController');

Route::resource('peliculas-de', 'GenreController');

