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
    return view('welcome');
});

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user-list', 'FriendController@userList')->name('user-list');
Route::get('/sent-requests', 'FriendController@sentRequests')->name('sent-requests');
Route::get('/my-requests', 'FriendController@myRequests')->name('my-requests');
Route::get('/friend-list', 'FriendController@friendList')->name('friend-list');
Route::post('/friend-search', 'FriendController@searchFriends')->name('friend-search');
Route::get('/add-friend/{id}', 'FriendController@addFriend')->name('add-friend');
Route::get('/approve-request/{id}', 'FriendController@approveRequest')->name('approve-request');
Route::get('/remove-friend/{id}', 'FriendController@removeFriend')->name('remove-friend');
