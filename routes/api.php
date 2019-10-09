<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ajax routes
Route::post('uploader/photo-upload','Uploader\PhotoUploadController@photoStore');
Route::get('media/photo/list','MediaDistributor\GetPhotoController@getPhotosList');
