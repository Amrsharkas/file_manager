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

Route::group(['middleware' => 'web'], function () {
Route::get('/get-dir', 'ie\fm\Http\Controllers\FileManagerController@getDirectory');
Route::get('/get-tree', 'ie\fm\Http\Controllers\FileManagerController@getTree');
Route::get('/get-js-tree', 'ie\fm\Http\Controllers\FileManagerController@getDirectoriesForTree');
//ViewController
Route::get('/preview-text', 'ie\fm\Http\Controllers\ViewController@previewFileAsText');
Route::get('/preview-media', 'ie\fm\Http\Controllers\ViewController@previewFileAsMedia');
    Route::get('/preview-media-url', 'ie\fm\Http\Controllers\ViewController@previewFileAsMediaUrl');

Route::post('/file-upload', 'ie\fm\Http\Controllers\UploadingController@uploadFilesByChunks')->name('files.upload.large');
Route::get('/rename-file', 'ie\fm\Http\Controllers\UploadingController@renameFileView');
Route::post('/post-rename-file', 'ie\fm\Http\Controllers\UploadingController@rename');
Route::get('/remove', 'ie\fm\Http\Controllers\UploadingController@remove');
Route::get('/move', 'ie\fm\Http\Controllers\UploadingController@moveView');
Route::get('/copy', 'ie\fm\Http\Controllers\UploadingController@moveView');
Route::post('/post-move-file', 'ie\fm\Http\Controllers\UploadingController@move');
Route::post('/post-copy-file', 'ie\fm\Http\Controllers\UploadingController@copy');

Route::get('/create-new', 'ie\fm\Http\Controllers\UploadingController@createNewView');
Route::post('/post-create-file', 'ie\fm\Http\Controllers\UploadingController@createNew');

Route::get('/download-single', 'ie\fm\Http\Controllers\DownloadController@downloadSingle');
Route::post('/write-file', 'ie\fm\Http\Controllers\UploadingController@writeFile');

Route::get('/get-compressed-link', 'ie\fm\Http\Controllers\DownloadController@getDownloadCompressedLink');

});