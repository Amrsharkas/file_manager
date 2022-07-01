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
Route::get('/get-dir', 'Emam\Filemanager\Http\Controllers\FileManagerController@getDirectory');
Route::get('/get-tree', 'Emam\Filemanager\Http\Controllers\FileManagerController@getTree');
Route::get('/get-js-tree', 'Emam\Filemanager\Http\Controllers\FileManagerController@getDirectoriesForTree');
//ViewController
Route::get('/preview-text', 'Emam\Filemanager\Http\Controllers\ViewController@previewFileAsText');
Route::get('/preview-media', 'Emam\Filemanager\Http\Controllers\ViewController@previewFileAsMedia');
    Route::get('/preview-media-url', 'Emam\Filemanager\Http\Controllers\ViewController@previewFileAsMediaUrl');

Route::post('/file-upload', 'Emam\Filemanager\Http\Controllers\UploadingController@uploadFilesByChunks')->name('files.upload.large');
Route::get('/rename-file', 'Emam\Filemanager\Http\Controllers\UploadingController@renameFileView');
Route::post('/post-rename-file', 'Emam\Filemanager\Http\Controllers\UploadingController@rename');
Route::get('/remove', 'Emam\Filemanager\Http\Controllers\UploadingController@remove');
Route::get('/move', 'Emam\Filemanager\Http\Controllers\UploadingController@moveView');
Route::get('/copy', 'Emam\Filemanager\Http\Controllers\UploadingController@moveView');
Route::post('/post-move-file', 'Emam\Filemanager\Http\Controllers\UploadingController@move');
Route::post('/post-copy-file', 'Emam\Filemanager\Http\Controllers\UploadingController@copy');

Route::get('/create-new', 'Emam\Filemanager\Http\Controllers\UploadingController@createNewView');
Route::post('/post-create-file', 'Emam\Filemanager\Http\Controllers\UploadingController@createNew');

Route::get('/download-single', 'Emam\Filemanager\Http\Controllers\DownloadController@downloadSingle');
Route::post('/write-file', 'Emam\Filemanager\Http\Controllers\UploadingController@writeFile');

Route::get('/get-compressed-link', 'Emam\Filemanager\Http\Controllers\DownloadController@getDownloadCompressedLink');

});