<?php

use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

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
    return redirect()->route('albums.index');
});

Route::get('/image/upload/{album_id}', [\App\Http\Controllers\ImageController::class, 'uploadForm'])
                                                                        ->where('album_id', '[0-9]+')
                                                                        ->name('upload.index');;
Route::post('/image', [\App\Http\Controllers\ImageController::class, 'uploadFile'])
                                                                        ->name('upload.uploadFile');
Route::get('/image/delete/{id}', [\App\Http\Controllers\ImageController::class, 'deleteFile'])
                                                                        ->name('image.delete')
                                                                        ->where('id', '[0-9]+');




Route::any('/albums', [AlbumController::class, 'getAllAlbums'])->name('albums.index');
Route::get('/albums/{id}', [AlbumController::class, 'getAlbum'])
                                                                        ->name('albums.view')
                                                                        ->where('id', '[0-9]+');

Route::get('/albums/create', function () {
    return view('album-create');
})->name('albums.create');

Route::post('/albums', [AlbumController::class, 'addAlbum'])->name('albums.add');
Route::get('/albums/delete/{id}', [AlbumController::class, 'deleteAlbum'])
                                                                        ->name('albums.delete')
                                                                        ->where('id', '[0-9]+');
Route::get('/albums/edit/{id}', [AlbumController::class, 'albumEditor'])
                                                                        ->name('albums.editor')
                                                                        ->where('id', '[0-9]+');
Route::post('/albums/edit', [AlbumController::class, 'editAlbum'])->name('albums.edit');



Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return redirect()->route('albums.index');
});
