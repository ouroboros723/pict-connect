<?php

use App\Http\Middleware\AuthPictConnectAccount;
use App\Http\Middleware\CheckEventJoined;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        Route::post('/photo-upload', [App\Http\Controllers\Uploader\PhotoUploadController::class, 'photoStore'])->name('photo_upload');
        Route::post('/photo-delete', [App\Http\Controllers\Uploader\PhotoDeleteController::class, 'photoDelete'])->name('photo_delete');
    });

    Route::prefix('media')->name('media.')->group(function() {
        Route::prefix('/photo')->name('photo.')->group(function() {
            Route::middleware(CheckEventJoined::class)->group(function() {
                Route::get('/list', [App\Http\Controllers\MediaDistributor\GetPhotoController::class, 'getPhotosList'])->name('list');
//    Route::get('/prev-list', [App\Http\Controllers\MediaDistributor\GetPhotoController::class, 'getPrevPhotosList'])->name('photo_delete');
                Route::get('/text-list', [App\Http\Controllers\MediaDistributor\GetPhotoController::class, 'getTextPhotosList'])->name('text_list');
            });
                Route::get('/{photo_id}', [App\Http\Controllers\MediaDistributor\GetPhotoController::class, 'getFullSizePhoto'])->name('get_full_size_photo');
                Route::get('/{photo_id}/thumbnail', [App\Http\Controllers\MediaDistributor\GetPhotoController::class, 'getThumbnail'])->name('thumbnail');
                Route::get('/{photo_id}/download', [App\Http\Controllers\MediaDistributor\GetPhotoController::class, 'downloadFullSizePhoto'])->name('download');
        });
        Route::get('/profile-icon/{user_id}', [App\Http\Controllers\MediaDistributor\GetPhotoController::class, 'getProfileIcon'])->name('profile_icon');
        Route::get('/event-icon/join-token/{joinToken}', [App\Http\Controllers\MediaDistributor\GetEventIconController::class, 'getEventIconFromJoinToken'])->name('event-icon.join-token');
        Route::middleware(CheckEventJoined::class)->group(function(){
            Route::get('/event-icon/{eventId}', [App\Http\Controllers\MediaDistributor\GetEventIconController::class, 'getEventIcon'])->name('event-icon');
        });
    });

    Route::prefix('event')->name('event.')->group(function() {
        Route::get('/list/joined', [App\Http\Controllers\EventsManage\EventsManageController::class, 'joinedList'])->name('list.joined');
        Route::get('/list/admin', [App\Http\Controllers\EventsManage\EventsManageController::class, 'adminList'])->name('list.admin');
        Route::post('/create', [App\Http\Controllers\EventsManage\EventsManageController::class, 'create'])->name('create');
        Route::get('/detail/join-token/{joinToken}', [App\Http\Controllers\EventsManage\EventsManageController::class, 'getEventDetailFromToken'])->name('detail.join_token');
        Route::middleware(CheckEventJoined::class)->group(function(){
            Route::get('/detail/{eventId}', [App\Http\Controllers\EventsManage\EventsManageController::class, 'getEventDetail'])->name('detail');
            Route::get('/zip/{eventId}', [App\Http\Controllers\EventsManage\EventsManageController::class, 'getAllEventPhotos'])->name('get_all_event_photos');
        });

        Route::post('/token/create/{eventId}', [App\Http\Controllers\EventsManage\EventsManageController::class, 'createJoinToken'])->name('token.create');
        Route::post('/join/{joinToken}', [App\Http\Controllers\EventsManage\EventsManageController::class, 'joinEvent'])->name('join');
    });
});

