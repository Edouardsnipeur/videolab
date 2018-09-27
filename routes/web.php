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

Route::get('/', 'FrontendController@index')->name('home');
Route::get('single/{video}', 'FrontendController@single')->name('single');
Route::get('category/{category}', 'FrontendController@category')->name('category');
Route::get('/search', 'FrontendController@search')->name('search');
Route::get('playlist','FrontendController@playlist')->name('playlist');
Route::get('playlist/{playlist}','FrontendController@playlistSingle')->name('playlistsingle');
Route::post('image', 'Admin\\VideoController@upload')->name('video.upload');
Route::get('image', 'Admin\\VideoController@affiche')->name('video.affiche');
Auth::routes();



Route::group(['as'=>'admin.','prefix'=>'admin', 'middleware'=>['auth','Admin'], 'namespace'=>'Admin'],function (){
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::post('playlist_manage', 'PlaylistController@insert_video')->name('playlist.manage');
    Route::resource('user', 'UserController');
    Route::resource('category', 'CategoryController');
    Route::get('pending','VideoController@pending')->name('pending');
    Route::put('approuve/{video}','VideoController@approuve')->name('approuve');
    Route::resource('playlist', 'PlaylistController');
    Route::resource('video','VideoController');


});

Route::group(['as'=>'user.','prefix'=>'user', 'middleware'=>['auth','User'], 'namespace'=>'User'],function (){
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('upload', 'VideoController@upload')->name('video.upload');
    Route::post('playlist_manage', 'PlaylistController@insert_video')->name('playlist.manage');
    Route::resource('playlist', 'PlaylistController');
    Route::resource('video','VideoController');
    Route::get('pending','VideoController@pending')->name('pending');

});
