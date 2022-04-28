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
Route::get('/get-dir', 'Ie\FileManager\Http\Controllers\FileManagerController@getDirectory');
Route::get('/get-tree', 'Ie\FileManager\Http\Controllers\FileManagerController@getTree');
Route::get('/get-js-tree', 'Ie\FileManager\Http\Controllers\FileManagerController@getDirectoriesForTree');
//ViewController
Route::get('/preview-text', 'Ie\FileManager\Http\Controllers\ViewController@previewFileAsText');
Route::get('/preview-media', 'Ie\FileManager\Http\Controllers\ViewController@previewFileAsMedia');

Route::post('/file-upload', 'Ie\FileManager\Http\Controllers\UploadingController@uploadFilesByChunks')->name('files.upload.large');
Route::get('/rename-file', 'Ie\FileManager\Http\Controllers\UploadingController@renameFileView');
Route::post('/post-rename-file', 'Ie\FileManager\Http\Controllers\UploadingController@rename');
Route::get('/remove', 'Ie\FileManager\Http\Controllers\UploadingController@remove');
Route::get('/move', 'Ie\FileManager\Http\Controllers\UploadingController@moveView');
Route::get('/copy', 'Ie\FileManager\Http\Controllers\UploadingController@moveView');
Route::post('/post-move-file', 'Ie\FileManager\Http\Controllers\UploadingController@move');
Route::post('/post-copy-file', 'Ie\FileManager\Http\Controllers\UploadingController@copy');

Route::get('/create-new', 'Ie\FileManager\Http\Controllers\UploadingController@createNewView');
Route::post('/post-create-file', 'Ie\FileManager\Http\Controllers\UploadingController@createNew');

Route::get('/download-single', 'Ie\FileManager\Http\Controllers\DownloadController@downloadSingle');
Route::post('/write-file', 'Ie\FileManager\Http\Controllers\UploadingController@writeFile');

Route::get('/get-compressed-link', 'Ie\FileManager\Http\Controllers\DownloadController@getDownloadCompressedLink');

});