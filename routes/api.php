<?php

use App\Http\Controllers\Admin\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('videos')->group(function () {
	Route::get('/get_all', [VideoController::class, 'get_all'])->name('admin.videos.get_all');
	Route::post('/store', [VideoController::class, 'store'])->name('admin.videos.store');
	Route::get('/delete/{id}', [VideoController::class, 'destroy'])->name('admin.videos.destroy');
});
