<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
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
\Debugbar::disable();

Route::get('/messages/getActive', [MessageController::class, 'getchanged']);




// Route::get('/app', [MessageController::class, 'index']);
// Route::get('/app/create', [MessageController::class, 'create']);
// Route::get('/app/{message}', [MessageController::class, 'show']);

Auth::routes();
// Route::resource('/messages', MessageController::class)->middleware('auth');
// Route::get('/home', [MessageController::class, 'index'])->name('home')->middleware('auth');

// Route::resource('/messages', MessageController::class);
Route::resource('/messages', MessageController::class)->middleware('auth');

Route::post('/messages/togglestatus/{message}', [MessageController::class, 'togglestatus']);
Route::get('/home', [MessageController::class, 'index'])->name('home');

Route::get('/logout', function(){
	Auth::logout();
	return redirect('/messages');
});

Route::get('/register', function(){
	return redirect('/messages');
});

Route::get('/', function(Illuminate\Http\Request $request){
	return view('kiosk');
});



