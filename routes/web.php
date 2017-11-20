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


Route::get('/messages/getActive', 'MessageController@getchanged');




// Route::get('/app', 'MessageController@index');
// Route::get('/app/create', 'MessageController@create');
// Route::get('/app/{message}', 'MessageController@show');

Auth::routes();
// Route::resource('/messages', 'MessageController')->middleware('auth');
// Route::get('/home', 'MessageController@index')->name('home')->middleware('auth');

Route::resource('/messages', 'MessageController');
Route::get('/home', 'MessageController@index')->name('home');

Route::get('/logout', function(){
	Auth::logout();
	return redirect('/messages');
});

Route::get('/register', function(){
	return redirect('/messages');
});



