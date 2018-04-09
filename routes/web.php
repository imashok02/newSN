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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//posts
Route::resource('/posts', 'PostController');


//friendship
Route::get('/add_request/{to}', 'FriendshipController@add_request')->name('add_request');
Route::get('/accept_request/{for}', 'FriendshipController@accept_request')->name('accept_request');
Route::get('/pending_requests', 'FriendshipController@pending_requests')->name('pending_request');
Route::get('/myfriends', 'FriendshipController@friend_list')->name('myfriends');
Route::get('/requests_sent', 'FriendshipController@pending_friend_requests_sent')->name('myfriends');


//Company
Route::resource('/pages', 'PageController');

//Groups
Route::resource('/groups', 'GroupController');
Route::get('/group/{groupid}/addmember/{id}', 'GroupController@add_member');
Route::get('/group/{groupid}/removemember/{id}', 'GroupController@remove_member');

//group member volunteer exit
Route::get('/group/{groupid}/exitgroup/{id}', 'GroupController@exit_group');


//Messages
Route::post('/messages/send', 'MessageController@send')->name('send.message');
Route::get('/messages/send', 'MessageController@msg')->name('send');
Route::get('/convos/{id}', 'MessageController@getConvo')->name('convo');
Route::get('/myconvos', 'MessageController@conversation_ids')->name('convoId');


//profile
Route::get('/profile/{id}', 'ProfileController@user');
Route::get('/profile/update/{id}', 'ProfileController@update_profile');

//search users
Route::get('/search', 'SearchController@user_search')->name('search.user');


//feed generate
Route::get('/feed', 'UserController@feed')->name('feed');

//likes
Route::get('/post/{postid}/like', 'PostController@like')->name('post.like');
Route::get('/post/{postid}/unlike', 'PostController@unlike')->name('post.unlike');

Route::get('/page/{pageid}/like', 'PageController@like')->name('page.like');
Route::get('/page/{pageid}/unlike', 'PageController@unlike')->name('page.unlike');


//shares
Route::get('/post/{postid}/share', 'PostController@share')->name('post.share');

Route::get('/page/{pageid}/share', 'PageController@share')->name('page.share');

