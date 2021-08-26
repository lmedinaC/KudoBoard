<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
*  Worker Routes
*
*/
Route::prefix('worker')->group(function () {
    //Return a list of all workers
    Route::get('/store', 'WorkerController@getAll')->name('worker.store');
});

/*
*  Board Routes
*
*/
Route::prefix('board')->group(function () {
    //Return a list of all boards
    Route::get('/store', 'BoardController@getAll')->name('board.store');
    //Return a board
    Route::get('/show/{board_id}', 'BoardController@show')->name('board.show');
    //Return a board
    Route::post('/show/recipients', 'BoardController@getRecipients')->name('board.recipients');
    //Return permissions board
    Route::post('/permissions/{board_id}', 'BoardController@permissions')->name('board.permissions');
    //Create a board
    Route::post('/create', 'BoardController@create')->name('board.create');
    //Update a board
    Route::put('/update/{board_id}', 'BoardController@update')->name('board.update');
    //delete a board
    Route::delete('/delete/{board_id}', 'BoardController@delete')->name('board.delete');

});

/*
*  Publication Routes
* 
*/
Route::prefix('publication')->group(function () {
    //Return posts of a board
    Route::get('/show/{board_id}', 'PublicationController@getByIdBoard')->name('publication.store');
    //create a post
    Route::post('/create', 'PublicationController@create')->name('publication.create');
    //Update a post
    Route::put('/update', 'PublicationController@update')->name('publication.update');
    //Delete a post
    Route::delete('/delete/{publication_id}', 'PublicationController@delete')->name('publication.delete');
});

/*
*   Guest Routes
* 
*/
Route::prefix('guest')->group(function () {
    //Return guest of a board
    Route::get('/get/{board_id}', 'GuestController@getInBoard')->name('guest.get');
    //create guest
    Route::post('/create', 'GuestController@createInBoard')->name('guest.create');
    //delete guest
    Route::delete('/delete/{board_id}', 'GuestController@delete')->name('guest.delete');
    
});


