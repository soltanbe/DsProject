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

Route::get('/','HomeController@index');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/getAllDataOfUser', 'HomeController@getAllDataOfUser');
    Route::post('/addFriend', 'HomeController@addFriend');
    Route::post('/deleteFriend', 'HomeController@deleteFriend');
    Route::post('/showAllFriends', 'HomeController@showAllFriends');
    Route::post('/showBrithdays', 'HomeController@showBrithdays');
    Route::post('/showPotenialFriends', 'HomeController@showPotenialFriends');
    Route::post('/showUpcomingBrithdays', 'HomeController@showUpcomingBrithdays');
});
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
