<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AboutsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\SiteManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now, let's build something great!
|
*/
Route::get('/send-otp', function () {
    return view('welcome');
});

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
Route::middleware(['auth'])->group(function () {
    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // User account settings
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePasswordPost'])->name('change_password.store');
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


Route::prefix('superAdmin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'super_admin_dashboard'])->name('super.admin.dashboard');
    Route::get('/users/{type}', [UsersController::class, 'index'])->name('superadmin.users.index');
    Route::get('/companies/{type}', [DashboardController::class, 'companies'])->name('superadmin.companies.index');
    Route::get('/user/{type}/search', [UsersController::class, 'search'])->name('superadmin.users.search');

    Route::patch('user/{id}/update-role', [UsersController::class, 'updateRole'])->name('superadmin.users.updateRole');
    Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('superadmin.users.destroy');



    Route::resource('/testimonials', TestimonialsController::class);
    Route::get('/testimonial/trash-view', [TestimonialsController::class, 'trashView'])->name('testimonial.trash-view');
    Route::delete('/testimonial/trash/{id}', [TestimonialsController::class, 'trashDelete'])->name('testimonial.trash');
    Route::delete('/testimonial/{id}', [TestimonialsController::class, 'delete'])->name('testimonial.delete');
    Route::get('/testimonial/restore/{id}', [TestimonialsController::class, 'restore'])->name('testimonial.restore');
    Route::patch('/testimonial/{id}/publish', [TestimonialsController::class, 'publish'])->name('testimonial.publish');
    Route::patch('/testimonial/{id}/unpublish', [TestimonialsController::class, 'unpublish'])->name('testimonial.unpublish');
    // Route::resource('category', CategoryController::class);
    Route::resource('/blogs', BlogsController::class);
    Route::get('/blog/trash-view', action: [BlogsController::class, 'trashView'])->name('blogs.trash-view');
    Route::delete('/blog/trash/{id}', [BlogsController::class, 'trashDelete'])->name('blog.trash');
    Route::get('/blog/restore/{id}', [BlogsController::class, 'restore'])->name('blog.restore');
    Route::patch('/blog/{id}/publish', [BlogsController::class, 'publish'])->name('blog.publish');
    Route::patch('/blog/{id}/unpublish', [BlogsController::class, 'unpublish'])->name('blog.unpublish');

    Route::resource('faqs', FAQController::class);
    Route::get('/faq/trash-view', action: [FAQController::class, 'trashView'])->name('faqs.trash-view');
    Route::delete('/faq/trash/{id}', [FAQController::class, 'trashDelete'])->name('faq.trash');
    Route::delete('/faq/{id}', [FAQController::class, 'delete'])->name('faq.delete');
    Route::get('/faq/restore/{id}', [FAQController::class, 'restore'])->name('faq.restore');
    Route::patch('/faq/{id}/publish', [FAQController::class, 'publish'])->name('faq.publish');
    Route::patch('/faq/{id}/unpublish', [FAQController::class, 'unpublish'])->name('faq.unpublish');



    Route::resource('teams', TeamsController::class);
    
    Route::resource('abouts', AboutsController::class);

    Route::resource('sites', SiteManagerController::class);
});

