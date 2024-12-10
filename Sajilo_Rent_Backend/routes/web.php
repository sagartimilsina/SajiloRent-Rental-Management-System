<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

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
// Auth Routes //
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login-store', [AuthController::class, 'login_store'])->name('normal_login_store');
Route::post('/register-store', [AuthController::class, 'register_store'])->name('normal_register_store');




Route::get('/otp/{user}', [AuthController::class, 'otp_page'])->name('otp');
Route::post('/otp', [AuthController::class, 'otp'])->name('verify-otp');
Route::get('/forgot-password', [AuthController::class, 'forgot_password_page'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password.post');
Route::get('/reset-password', [AuthController::class, 'reset_password_page'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'reset_password'])->name('reset-password.post');
Route::post('/resend-otp', [AuthController::class, 'resend_otp_page'])->name('resend-otp');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//google login routes
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google_login');

// Handle callback from Google
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::prefix('admin')->middleware('auth:users')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});








Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-details/{id}', [FrontendController::class, 'blog_details'])->name('blog_details');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/product/{categoryId}/{subcategoryId}', [FrontendController::class, 'product'])->name('product');





