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
	return redirect('/index');
});
Route::post('/video/upload', ['uses' => 'VideoController@uploadVideo']);
Route::get('/dev', function(){ return view('welcome');});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/video', ['uses' => 'VideoController@getVideo']); 
Route::get('/video/ajax', ['uses' => 'VideoController@getVideoData']); 
Route::get('/video/subtitle', ['uses' => 'VideoController@getVideoSubtitle']);
Route::get('/try/variable', ['uses' => 'VideoController@tryVariable']);
Route::get('/index', ['uses' => 'VideoController@getIndex']); 
Route::get('/videoPage', ['uses' => 'VideoController@getVideoPage']); 

Auth::routes();
Route::get('/insertVideo', ['middleware' => 'auth', 'uses' => 'VideoController@getInsertVideo']);
Route::get('/videoList', ['middleware' => 'auth', 'uses' => 'VideoController@getUserVideoList']);
Route::post('/insertVideo', ['uses' => 'VideoController@insertVideo']);
Route::get('/insertList', function(){return view('chooseByList');});
Route::get('/home', 'HomeController@index2')->name('index');
Route::get('/index', 'HomeController@index2')->name('index');
