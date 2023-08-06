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
/*** 認証 ***/

// 標準ログインルートインポート
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// TwitterログインURL
Route::get('login/twitter', 'Auth\TwitterController@redirectToProvider'); //標準ログインにそろえて
// TwitterコールバックURL
Route::get('auth/twitter/callback', 'Auth\TwitterController@handleProviderCallback');
// TwitterログアウトURL
Route::get('auth/twitter/logout', 'Auth\TwitterController@logout');

Route::middleware(['cors'])->group(function () {

    // 紹介ページ
//    Route::get('/about', function () {
//        return view('welcome');
//    })->name('about');

    // 会員専用ページ
    Route::group(['middleware' => 'auth'], function () {
        // web ui routes
        Route::get('/', 'Viewer\EventLibController@index');
        Route::get('/event-grid-show', 'Viewer\EventLibController@gridShow');
        Route::view('/event-slide-show', 'viewer.pages.event-lib-slideshow');
        Route::view('/users', 'viewer.pages.user-list');
        Route::view('/user-lib', 'viewer.pages.user-lib');
        Route::get('/user/edit', 'Viewer\UserEditController@show');
        Route::post('/user/edit', 'Viewer\UserEditController@update');
    });

});
