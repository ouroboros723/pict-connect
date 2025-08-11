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

Route::middleware(AuthPictConnectAccount::class)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

// ajax routes
    Route::prefix('uploader')->name('uploader.')->group(function() {
        Route::post('/photo-upload', 'Uploader\PhotoUploadController@photoStore')->name('photo_upload');
        Route::post('/photo-delete', 'Uploader\PhotoDeleteController@photoDelete')->name('photo_delete');
    });

    Route::prefix('media')->name('media.')->group(function() {
        Route::prefix('/photo')->name('photo.')->group(function() {
            Route::middleware(CheckEventJoined::class)->group(function() {
                Route::get('/list', 'MediaDistributor\GetPhotoController@getPhotosList')->name('list');
//    Route::get('/prev-list', 'MediaDistributor\GetPhotoController@getPrevPhotosList')->name('photo_delete');
                Route::get('/text-list', 'MediaDistributor\GetPhotoController@getTextPhotosList')->name('text_list');
            });
                Route::get('/{photo_id}', 'MediaDistributor\GetPhotoController@getFullSizePhoto')->name('get_full_size_photo');
                Route::get('/{photo_id}/thumbnail', 'MediaDistributor\GetPhotoController@getThumbnail')->name('thumbnail');
                Route::get('/{photo_id}/download', 'MediaDistributor\GetPhotoController@downloadFullSizePhoto')->name('download');
        });
        Route::get('/profile-icon/{user_id}', 'MediaDistributor\GetPhotoController@getProfileIcon')->name('profile_icon');
        Route::get('/event-icon/join-token/{joinToken}', 'MediaDistributor\GetEventIconController@getEventIconFromJoinToken')->name('event-icon.join-token');
        Route::middleware(CheckEventJoined::class)->group(function(){
            Route::get('/event-icon/{eventId}', 'MediaDistributor\GetEventIconController@getEventIcon')->name('event-icon');
        });
    });

    Route::prefix('event')->name('event.')->group(function() {
        Route::get('/list/joined', 'EventsManage\EventsManageController@joinedList')->name('list.joined');
        Route::get('/list/admin', 'EventsManage\EventsManageController@adminList')->name('list.admin');
        Route::post('/create', 'EventsManage\EventsManageController@create')->name('create');
        Route::get('/detail/join-token/{joinToken}', 'EventsManage\EventsManageController@getEventDetailFromToken')->name('detail.join_token');
        Route::middleware(CheckEventJoined::class)->group(function(){
            Route::get('/detail/{eventId}', 'EventsManage\EventsManageController@getEventDetail')->name('detail');
            Route::get('/zip/{eventId}', 'EventsManage\EventsManageController@getAllEventPhotos')->name('get_all_event_photos');
        });

        Route::post('/token/create/{eventId}', 'EventsManage\EventsManageController@createJoinToken')->name('token.create');
        Route::post('/join/{joinToken}', 'EventsManage\EventsManageController@joinEvent')->name('join');
    });
});

