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
    });

// ajax routes
    Route::post('uploader/photo-upload', 'Uploader\PhotoUploadController@photoStore');
    Route::post('uploader/photo-delete', 'Uploader\PhotoDeleteController@photoDelete');
    Route::get('media/photo/list', 'MediaDistributor\GetPhotoController@getPhotosList');
//    Route::get('media/photo/prev-list', 'MediaDistributor\GetPhotoController@getPrevPhotosList');
    Route::get('media/photo/text-list', 'MediaDistributor\GetPhotoController@getTextPhotosList');
    Route::get('media/photo/{photo_id}', 'MediaDistributor\GetPhotoController@getFullSizePhoto');
    Route::get('media/photo/{photo_id}/thumbnail', 'MediaDistributor\GetPhotoController@getThumbnail');
    Route::get('media/photo/{photo_id}/download', 'MediaDistributor\GetPhotoController@downloadFullSizePhoto');
    Route::get('media/profile-icon/{user_id}', 'MediaDistributor\GetPhotoController@getProfileIcon');
});

