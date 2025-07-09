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
use App\Http\Middleware\CheckEventJoined;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/event/joined'); // リダイレクトパス

Auth::routes();

// はじめての方画面
Route::view('welcome', 'welcome');

// TwitterログインURL
Route::get('login/twitter', 'App\Http\Controllers\Auth\TwitterController@redirectToProvider'); //標準ログインにそろえて
// TwitterコールバックURL
Route::get('auth/twitter/callback', 'App\Http\Controllers\Auth\TwitterController@handleProviderCallback');
// TwitterログアウトURL
Route::get('auth/twitter/logout', 'App\Http\Controllers\Auth\TwitterController@logout');

Route::middleware(['cors'])->group(function () {

    // 紹介ページ
//    Route::get('/about', function () {
//        return view('welcome');
//    })->name('about');

    // 会員専用ページ
    Route::group(['middleware' => 'auth'], function () {
        // web ui routes
//        Route::get('/', 'Viewer\EventLibController@index');
        Route::get('/event/join/{joinToken}', 'App\Http\Controllers\Viewer\EventLibController@joinEvent');
        Route::get('/event/joined', 'App\Http\Controllers\Viewer\EventLibController@index');
        Route::middleware('event.joined')->get('/event/joined/{eventId}', 'App\Http\Controllers\Viewer\EventLibController@joindEvent');
        Route::get('/event-grid-show', 'App\Http\Controllers\Viewer\EventLibController@index');
        Route::middleware('event.joined')->get('/event/joined/{eventId}/slide', 'App\Http\Controllers\Viewer\EventLibController@slideShow');
        Route::view('/users', 'viewer.pages.user-list');
        Route::view('/user-lib', 'viewer.pages.user-lib');
        Route::view('/event/create', 'viewer.pages.event-create');
        Route::get('/user/edit', 'App\Http\Controllers\Viewer\UserEditController@show');
        Route::post('/user/edit', 'App\Http\Controllers\Viewer\UserEditController@update');
    });

});
