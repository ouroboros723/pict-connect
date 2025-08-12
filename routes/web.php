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
//        Route::get('/', 'Viewer\EventLibController@index');
        Route::get('/event/join/{joinToken}', 'Viewer\EventLibController@joinEvent');
        Route::get('/event/joined', 'Viewer\EventLibController@index');
        Route::middleware(CheckEventJoined::class)->get('/event/joined/{eventId}', 'Viewer\EventLibController@joindEvent');
        Route::get('/event-grid-show', 'Viewer\EventLibController@index');
        Route::middleware(CheckEventJoined::class)->get('/event/joined/{eventId}/slide', 'Viewer\EventLibController@slideShow');
        Route::view('/users', 'viewer.pages.user-list');
        Route::view('/user-lib', 'viewer.pages.user-lib');
        Route::view('/event/create', 'viewer.pages.event-create');
        Route::get('/event/edit/{eventId}', 'Viewer\EventEditController@show');

        // デバッグ用ルート（一時的）
//        Route::get('/debug/event/{eventId}', function($eventId) {
//            $event = \App\Model\Event::withTrashed()->find($eventId);
//            if (!$event) {
//                return response()->json(['error' => 'Event not found', 'eventId' => $eventId]);
//            }
//            return response()->json([
//                'event' => $event,
//                'is_deleted' => $event->trashed(),
//                'deleted_at' => $event->deleted_at
//            ]);
//        });

        // ミドルウェアテスト用ルート（一時的）
//        Route::middleware(CheckEventJoined::class)->get('/debug/middleware-test', function(\Illuminate\Http\Request $request) {
//            return response()->json([
//                'message' => 'Middleware passed',
//                'event_id' => $request->input('event_id'),
//                'eventId' => $request->input('eventId'),
//                'route_eventId' => $request->route('eventId')
//            ]);
//        });

        Route::get('/user/edit', 'Viewer\UserEditController@show');
        Route::post('/user/edit', 'Viewer\UserEditController@update');
    });

});
