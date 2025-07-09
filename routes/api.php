<?php

use App\Http\Middleware\AuthPictConnectAccount;
use App\Http\Middleware\CheckEventJoined;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.pict-connect')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

// ajax routes
    Route::prefix('uploader')->name('uploader.')->group(function() {
        Route::post('/photo-upload', 'App\Http\Controllers\Uploader\PhotoUploadController@photoStore')->name('photo_upload');
        Route::post('/photo-delete', 'App\Http\Controllers\Uploader\PhotoDeleteController@photoDelete')->name('photo_delete');
    });

    Route::prefix('media')->name('media.')->group(function() {
        Route::prefix('/photo')->name('photo.')->group(function() {
            Route::middleware('event.joined')->group(function() {
                Route::get('/list', 'App\Http\Controllers\MediaDistributor\GetPhotoController@getPhotosList')->name('list');
//    Route::get('/prev-list', 'App\Http\Controllers\MediaDistributor\GetPhotoController@getPrevPhotosList')->name('photo_delete');
                Route::get('/text-list', 'App\Http\Controllers\MediaDistributor\GetPhotoController@getTextPhotosList')->name('text_list');
            });
                Route::get('/{photo_id}', 'App\Http\Controllers\MediaDistributor\GetPhotoController@getFullSizePhoto')->name('get_full_size_photo');
                Route::get('/{photo_id}/thumbnail', 'App\Http\Controllers\MediaDistributor\GetPhotoController@getThumbnail')->name('thumbnail');
                Route::get('/{photo_id}/download', 'App\Http\Controllers\MediaDistributor\GetPhotoController@downloadFullSizePhoto')->name('download');
        });
        Route::get('/profile-icon/{user_id}', 'App\Http\Controllers\MediaDistributor\GetPhotoController@getProfileIcon')->name('profile_icon');
        Route::get('/event-icon/join-token/{joinToken}', 'App\Http\Controllers\MediaDistributor\GetEventIconController@getEventIconFromJoinToken')->name('event-icon.join-token');
        Route::middleware('event.joined')->group(function(){
            Route::get('/event-icon/{eventId}', 'App\Http\Controllers\MediaDistributor\GetEventIconController@getEventIcon')->name('event-icon');
        });
    });

    Route::prefix('event')->name('event.')->group(function() {
        Route::get('/list/joined', 'App\Http\Controllers\EventsManage\EventsManageController@joinedList')->name('list.joined');
        Route::get('/list/admin', 'App\Http\Controllers\EventsManage\EventsManageController@adminList')->name('list.admin');
        Route::post('/create', 'App\Http\Controllers\EventsManage\EventsManageController@create')->name('create');
        Route::get('/detail/join-token/{joinToken}', 'App\Http\Controllers\EventsManage\EventsManageController@getEventDetailFromToken')->name('detail.join_token');
        Route::middleware('event.joined')->group(function(){
            Route::get('/detail/{eventId}', 'App\Http\Controllers\EventsManage\EventsManageController@getEventDetail')->name('detail');
            Route::get('/zip/{eventId}', 'App\Http\Controllers\EventsManage\EventsManageController@getAllEventPhotos')->name('get_all_event_photos');
        });

        Route::post('/token/create/{eventId}', 'App\Http\Controllers\EventsManage\EventsManageController@createJoinToken')->name('token.create');
        Route::post('/join/{joinToken}', 'App\Http\Controllers\EventsManage\EventsManageController@joinEvent')->name('join');
    });
});

