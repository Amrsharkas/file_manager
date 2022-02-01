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

Route::get('/', function () {
});

Route::get('/get-dir', 'App\Http\Controllers\FileManagerController@getDirectory');
Route::get('/get-tree', 'App\Http\Controllers\FileManagerController@getTree');
Route::get('/get-js-tree', 'App\Http\Controllers\FileManagerController@getDirectoriesForTree');
//ViewController
Route::get('/preview-text', 'App\Http\Controllers\ViewController@previewFileAsText');
Route::get('/preview-media', 'App\Http\Controllers\ViewController@previewFileAsMedia');

Route::post('/file-upload', 'App\Http\Controllers\UploadController@uploadFilesByChunks')->name('files.upload.large');
Route::get('/rename-file', 'App\Http\Controllers\UploadController@renameFileView');
Route::post('/post-rename-file', 'App\Http\Controllers\UploadController@rename');
Route::get('/remove', 'App\Http\Controllers\UploadController@remove');
Route::get('/move', 'App\Http\Controllers\UploadController@moveView');
Route::get('/copy', 'App\Http\Controllers\UploadController@moveView');
Route::post('/post-move-file', 'App\Http\Controllers\UploadController@move');
Route::post('/post-copy-file', 'App\Http\Controllers\UploadController@copy');

Route::get('/create-new', 'App\Http\Controllers\UploadController@createNewView');
Route::post('/post-create-file', 'App\Http\Controllers\UploadController@createNew');

Route::get('/download-single', 'App\Http\Controllers\DownloadController@downloadSingle');
Route::post('/write-file', 'App\Http\Controllers\UploadController@writeFile');

Route::get('/get-compressed-link', 'App\Http\Controllers\DownloadController@getDownloadCompressedLink');

