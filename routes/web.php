<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AboutsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteManagerController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\RequestOwnerListsController;
use App\Http\Controllers\TenantAgreementwithSystemController;

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
Route::middleware(['auth', 'user'])->group(function () {

    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/request/submit', [FrontendController::class, 'submitRequest'])->name('request_submit');

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

// Super Admin Routes
Route::middleware(['auth', 'superAdmin'])->prefix('superAdmin')->group(function () {
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

    Route::resource('/RequestOwnerLists', RequestOwnerListsController::class);
    Route::patch('/RequestOwnerLists/approve/{id}', action: [RequestOwnerListsController::class, 'approve'])->name('RequestOwnerLists.approve');
    Route::patch('/RequestOwnerLists/reject/{id}', action: [RequestOwnerListsController::class, 'reject'])->name('RequestOwnerLists.reject');
    Route::get('/RequestOwnerList/trashed', [RequestOwnerListsController::class, 'trash'])->name('RequestOwnerLists.trash');
    Route::get('/RequestOwnerList/restore/{id}', [RequestOwnerListsController::class, 'restore'])->name('request_owner_lists.restore');
    Route::delete('/RequestOwnerList/delete/{id}', [RequestOwnerListsController::class, 'delete'])->name('request_owner_lists.delete');

    Route::resource('teams', TeamsController::class);

    Route::resource('abouts', AboutsController::class);

    Route::resource('sites', SiteManagerController::class);
    Route::resource('/tenants-agreements', TenantAgreementwithSystemController::class);
    Route::get('/tenant-agreements/trashed', [TenantAgreementwithSystemController::class, 'trash'])->name('tenants-agreements.trash');
    Route::get('/generateAgreementPDF/{id}', [TenantAgreementwithSystemController::class, 'generateAgreementPDF'])->name('superadmin.generateAgreementPDF');
    Route::delete('/tenant-agreement/delete/{id}', [TenantAgreementwithSystemController::class, 'delete'])->name('tenant-agreements.delete');
    Route::get('/tenant-agreement/restore/{id}', [TenantAgreementwithSystemController::class, 'restore'])->name('tenant_agreement.restore');
});





// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin_dashboard'])->name('admin.dashboard');
    Route::get('/users/{type?}', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('/companies/{type}', [DashboardController::class, 'companies'])->name('admin.companies.index');
    Route::get('/user/{type}/search', [UsersController::class, 'search'])->name('admin.users.search');
    Route::patch('user/{id}/update-role', [UsersController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('agreement', [TenantAgreementwithSystemController::class, 'index'])->name('admin.agreement.index');
    Route::get('/generateAgreementPDF/{id}', [TenantAgreementwithSystemController::class, 'generateAgreementPDF'])->name('admin.generateAgreementPDF');


});



