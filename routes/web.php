<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ContentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('playlists', [PlaylistController::class, 'index'])->name('playlists.index');
Route::get('playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
Route::post('playlists/upsert', [PlaylistController::class, 'upsert'])->name('playlists.upsert');
Route::delete('playlists/{id}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
Route::get('playlists/contents/{id}', [PlaylistController::class, 'contents'])->name('playlists.contents');


Route::get('contents', [ContentController::class, 'index'])->name('contents.index');
Route::get('contents/{id}/edit', [ContentController::class, 'edit'])->name('contents.edit');
Route::post('contents/upsert', [ContentController::class, 'upsert'])->name('contents.upsert');
Route::delete('contents/{id}', [ContentController::class, 'destroy'])->name('contents.destroy');
Route::get('contents/playlist/{id?}', [ContentController::class, 'playlist'])->name('contents.playlist');