<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});


Auth::routes();

Route::get('/home', 'UserController@loadDashboard')->middleware(['auth'])->name('home');

Route::post('/save-message', 'UserController@saveMessage');

Route::post('/load-messages', 'UserController@loadMessages');

Route::post('/message-deleted', 'UserController@deleteMessages');

Route::post('/update-message', 'UserController@updateMessage');

///Groups Routes
Route::get('/groups', 'GroupController@loadGroup')->middleware(['auth'])->name('groups');

Route::post('/create-group', 'GroupController@createGroup');


//Members Routs

Route::post('/get-members', 'MembersController@getMembers')->middleware(['auth'])->name('groups');



