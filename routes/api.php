<?php

use App\Http\Middleware\AuthPictConnectAccount;
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
            Route::get('/list', 'MediaDistributor\GetPhotoController@getPhotosList')->name('list');
//    Route::get('/prev-list', 'MediaDistributor\GetPhotoController@getPrevPhotosList')->name('photo_delete');
            Route::get('/text-list', 'MediaDistributor\GetPhotoController@getTextPhotosList')->name('text_list');
            Route::get('/{photo_id}', 'MediaDistributor\GetPhotoController@getFullSizePhoto')->name('get_full_size_photo');
            Route::get('/{photo_id}/thumbnail', 'MediaDistributor\GetPhotoController@getThumbnail')->name('thumbnail');
            Route::get('/{photo_id}/download', 'MediaDistributor\GetPhotoController@downloadFullSizePhoto')->name('download');
        });
        Route::get('/profile-icon/{user_id}', 'MediaDistributor\GetPhotoController@getProfileIcon')->name('profile_icon');
    });

    Route::prefix('event')->name('event.')->group(function() {
        Route::get('/list/joined', 'EventsManage\EventsManageController@joinedList')->name('list.joined');
        Route::get('/list/admin', 'EventsManage\EventsManageController@adminList')->name('list.admin');
        Route::post('/create', 'EventsManage\EventsManageController@create')->name('create');
        Route::post('/token/create/{eventId}', 'EventsManage\EventsManageController@createJoinToken')->name('token.create');
        Route::post('/join/{eventId}', 'EventsManage\EventsManageController@joinEvent')->name('join');
    });
});

