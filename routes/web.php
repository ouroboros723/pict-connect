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

Auth::routes();
// ログインURL
Route::get('auth/twitter', 'Auth\TwitterController@redirectToProvider');
// コールバックURL
Route::get('auth/twitter/callback', 'Auth\TwitterController@handleProviderCallback');
// ログアウトURL
Route::get('auth/twitter/logout', 'Auth\TwitterController@logout');

//Route::get('/home', function () {
//    return view('welcome');
//});

Route::middleware(['cors'])->group(function () {

    Route::group(['middleware' => 'auth'], function () {
// web ui routes
        Route::get('/', 'Viewer\EventLibController@index');
        Route::view('/users', 'viewer.pages.user-list');
        Route::view('/user-lib', 'viewer.pages.user-lib');

    });

});
