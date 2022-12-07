<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('save-record', [PostController::class, 'saveRecord']);
Route::get('list-records', [PostController::class, 'listRecord']);
Route::get('detail-record/{id}', [PostController::class, 'detailRecord']);


Route::get('local/temp/{path}', function (string $path) {
    return Storage::disk('public')->download($path);
})->name('local.temp');

Route::get('/get-temporary/{path}', [PostController::class, 'temporary']);
