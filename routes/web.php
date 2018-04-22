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


Route::get('/', function () {
    //return view('welcome');
	return redirect('/index.html');
});
Route::post('/video/upload', ['uses' => 'VideoController@uploadVideo']);
Route::get('/dev', function(){ return view('welcome');});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/video', ['uses' => 'VideoController@getVideo']); 
Route::get('/video/ajax', ['uses' => 'VideoController@getVideoData']); 
Route::get('/video/subtitle', ['uses' => 'VideoController@getVideoSubtitle']);
Route::get('/try/variable', ['uses' => 'VideoController@tryVariable']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
