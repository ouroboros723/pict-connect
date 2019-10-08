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

//Route::get('/', function () {
//    return view('welcome');
//});

// web ui routes
Route::view('/', 'viewer.pages.event-lib');
Route::view('/users', 'viewer.pages.user-list');
Route::view('/user-lib', 'viewer.pages.user-lib');

