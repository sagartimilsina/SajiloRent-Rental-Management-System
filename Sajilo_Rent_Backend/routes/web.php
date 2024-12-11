<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now, let's build something great!
|
*/

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login-store', [AuthController::class, 'login_store'])->name('login.store');
    Route::post('/register-store', [AuthController::class, 'register_store'])->name('register.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Password and OTP routes
    Route::get('/forgot-password', [AuthController::class, 'forgot_password_page'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password.post');
    Route::get('/reset-password', [AuthController::class, 'reset_password_page'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'reset_password'])->name('reset-password.post');
    Route::get('/otp', [AuthController::class, 'otp_page'])->name('otp');
    Route::post('/verify-otp', [AuthController::class, 'otp_verify'])->name('verify.otp');
    Route::get('/resend-otp/{user_id}', [AuthController::class, 'resend_otp_page'])->name('resend.otp');
});

// Google Login Routes
Route::prefix('auth/google')->group(function () {
    Route::get('/', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Authenticated User Routes
Route::middleware(['auth', 'role:User'])->group(function () {
    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // User account settings
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePasswordPost'])->name('change.password.post');
    Route::get('/email-verify', [AuthController::class, 'showVerificationPage'])->name('email.verify');
    Route::post('/email-verify', [AuthController::class, 'email_verify'])->name('email.verify.post');
    Route::get('/otp-verify', [AuthController::class, 'showOtpVerificationPage'])->name('otp.verify');
    Route::post('/otp-verify', [AuthController::class, 'otp_verify'])->name('otp.verify.post');
    Route::get('/new-password', [AuthController::class, 'showChangeCredentialsPage'])->name('new.password');
    Route::post('/new-password', [AuthController::class, 'changeCredentials'])->name('new.password.post');
});

// Frontend Routes
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog-details/{id}', 'blog_details')->name('blog.details');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/product/{categoryId}/{subcategoryId}', 'product')->name('product');
});
