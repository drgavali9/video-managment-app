<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MembershipController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\OurPressController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\RecipeController;
use App\Http\Controllers\Frontend\WholesaleController;
use App\Http\Controllers\Server\OdooController;
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
