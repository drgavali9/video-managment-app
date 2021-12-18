<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Admin
require __DIR__ . '/admin.php';
Route::get('/', [LoginController::class, 'index']);

Route::middleware(['localization'])->group(function () {
	Route::prefix('admin')
		->middleware(["throttle"])
		->group(function () {
			Route::get('/login', [LoginController::class, 'index'])->name('admin.login.view');

			Route::post('/login', [LoginController::class, 'login'])->name('admin.login');

			Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
				->middleware('guest')
				->name('admin.forgot.password.form');

			Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
				->middleware('guest')
				->name('admin.forgot.password.store');

			Route::get('/reset-password/{token}', [PasswordResetLinkController::class, 'edit'])
				->middleware('guest')
				->name('admin.reset.password.form');

			Route::post('/reset-password/{token}', [PasswordResetLinkController::class, 'update'])
				->middleware('guest')
				->name('admin.reset.password.update');
		});
	Route::prefix('admin')
		->middleware(['auth', "admin-authenticate", "throttle"])
		->group(function () {
			Route::post('/logout', [LoginController::class, 'destroy'])
				->name('logout');

			// Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

			Route::prefix('videos')->group(function () {
				Route::get('/', [VideoController::class, 'index'])->name('admin.videos.index');
				Route::get('/add', [VideoController::class, 'create'])->name('admin.videos.create');
				Route::post('/store', [VideoController::class, 'store'])->name('admin.videos.store');
				Route::get('/edit/{id}', [VideoController::class, 'edit'])->name('admin.videos.edit');
				Route::post('/update/{id}', [VideoController::class, 'update'])->name('admin.videos.update');
				Route::post('/subupdate/{id}', [VideoController::class, 'subupdate'])->name('admin.videos.sub.update');
				Route::post('/delete/{id}', [VideoController::class, 'destroy'])->name('admin.videos.delete');
				Route::post('/statusUpdate/{id}', [VideoController::class, 'statusUpdate'])->name('admin.videos.statusUpdate');
			});
		});
});
