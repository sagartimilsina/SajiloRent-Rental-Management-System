<?php

use App\Models\Payments;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FAQController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\UsersController;

use App\Http\Controllers\AboutsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropeertyController;
use App\Http\Controllers\CategoriesController;

use App\Http\Controllers\FavouritesController;
use App\Http\Controllers\SiteManagerController;
use App\Http\Controllers\EsewaPaymentController;
use App\Http\Controllers\SliderImagesController;
use App\Http\Controllers\TestimonialsController;

use App\Http\Controllers\KhaltiPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\PropertyImagesController;
use App\Http\Controllers\PropertyReviewController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\MessageChatController;
use App\Http\Controllers\RequestOwnerListsController;
use App\Http\Controllers\TenantAgreementwithSystemController;

use App\Http\Controllers\ContactController;

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



Route::get('/send-message', [MessageChatController::class, 'index'])->name('send-message')->middleware('auth');
Route::get('/message', [MessageChatController::class, 'show'])->name('message.show')->middleware('auth');
Route::get('/chat/{user}', [MessageChatController::class, 'getUserChat']);
Route::resource('messages', MessageChatController::class);
Route::get('/send-message/{user_id}/{user_name}', [MessageChatController::class, 'showChat'])->name('send-message-user')->middleware('auth');

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
    Route::get('/dashboard', [DashboardController::class, 'user_dashboard'])->name('user.dashboard');

    Route::get('/list-property/request', [FrontendController::class, 'request'])->name('list-property');
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
    Route::post('/property/{id}/review', [PropertyReviewController::class, 'store'])->name('property.review.store');
    Route::post('/favorites/toggle', [FavouritesController::class, 'store'])->name('favorites.toggle');
    Route::get('/favorites/list', [FavouritesController::class, 'myFavourites'])->name('favorites.list');

    Route::post('cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::post('/property/message/store', [PropeertyController::class, 'message_store'])->name('property.message.store');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{property_id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Esewa Payment Routes
    Route::post('/esewa/checkout', [EsewaPaymentController::class, 'esewaPayment'])->name('esewa.payment');
    Route::get('/esewa/success', [EsewaPaymentController::class, 'success'])->name('esewa.success');
    Route::get('/esewa/failure', [EsewaPaymentController::class, 'failure'])->name('esewa.failure');
    Route::get('/esewa/invoice/{transaction_uuid}', [EsewaPaymentController::class, 'paymentInvoice'])->name('esewa.invoice');

    // contact form store


    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


    Route::post('/khalti/initiate', [KhaltiPaymentController::class, 'initiatePayment'])->name('khalti.initiate');
    Route::get('/khalti/verify', [KhaltiPaymentController::class, 'verifyPayment'])->name('khalti.verify');
    Route::get('/payment/success', [KhaltiPaymentController::class, 'success'])->name('khalti.success');
    Route::get('/payment/failed', [KhaltiPaymentController::class, 'failed'])->name('khalti.failed');


    Route::post('/payment/process', [StripePaymentController::class, 'processPayment'])->name('payment.process.stripe');
    Route::get('/payment/success', [StripePaymentController::class, 'paymentSuccess'])->name('payment.success.stripe');
    Route::get('/payment/failure', [StripePaymentController::class, 'paymentFailure'])->name('payment.failure.stripe');
    Route::get('/payment/invoice/{transaction_uuid}', [StripePaymentController::class, 'paymentInvoice'])->name('payment.invoice.stripe');


    Route::prefix('profile')->group(function () {
        Route::get('/my-cart', [DashboardController::class, 'myCart'])->name('profile.myCart');
        Route::get('/payment-history', [DashboardController::class, 'myPaymentHistory'])->name('profile.paymentHistory');
        Route::get('/your-favorites', [DashboardController::class, 'myFavourites'])->name('profile.myFavourites');
        Route::get('/edit-profile', [DashboardController::class, 'editProfile'])->name('profile.editProfile');
        Route::get('/my-chats', [DashboardController::class, 'myChats'])->name('profile.myChats');
        Route::get('/edit', [DashboardController::class, 'edit'])->name('profile.edit');
        Route::patch('/update/{id?}', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/payment-invoice/{transaction_uuid}', [DashboardController::class, 'paymentInvoice'])->name('profile.payment.invoice');
    });
});

// Route::post('/favorites/toggle', [FavouritesController::class, 'store'])->name('favorites.toggle');

// Frontend Routes
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog-details/{id}', 'blog_details')->name('blog.details');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/product/{categoryId}  ', 'product_filter')->name('product');
    Route::get('/products-or-property', 'product_or_property')->name('product_or_property');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/get-subcategories/{categoryId}', 'getSubCategories')->name('get.subcategories');

    Route::get('/property-details/{id}', 'property_details')->name('property.details');
    Route::get('/about-dynamic/{id}', 'dynamic')->name('about_dynamic');
    Route::get('/properties', 'properties')->name('properties.index');
    Route::get('/properties/search', 'search')->name('properties.search');

    // Filter properties
    Route::get('/properties/filter', 'filter')->name('properties.filter');
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
    Route::get('team/trash-view', action: [TeamsController::class, 'trashView'])->name('teams.trash-view');
    Route::delete('team/trash/{id}', [TeamsController::class, 'trashDelete'])->name('team.trash');
    Route::delete('team/{id}', [TeamsController::class, 'delete'])->name('team.delete');
    Route::get('team/restore/{id}', [TeamsController::class, 'restore'])->name('team.restore');
    Route::patch('team/{id}/publish', [TeamsController::class, 'publish'])->name('team.publish');
    Route::patch('team/{id}/unpublish', [TeamsController::class, 'unpublish'])->name('team.unpublish');

    Route::get('team/trash-view', action: [TeamsController::class, 'trashView'])->name('teams.trash-view');
    Route::delete('team/trash/{id}', [TeamsController::class, 'trashDelete'])->name('team.trash');
    Route::delete('team/{id}', [TeamsController::class, 'delete'])->name('team.delete');
    Route::get('team/restore/{id}', [TeamsController::class, 'restore'])->name('team.restore');
    Route::patch('team/{id}/publish', [TeamsController::class, 'publish'])->name('team.publish');
    Route::patch('team/{id}/unpublish', [TeamsController::class, 'unpublish'])->name('team.unpublish');


    Route::resource('abouts', AboutsController::class);
    Route::get('/about/trash-view', action: [AboutsController::class, 'trashView'])->name('abouts.trash-view');
    Route::patch('/about/{id}/publish', [AboutsController::class, 'publish'])->name('about.publish');
    Route::patch('/about/{id}/unpublish', [AboutsController::class, 'unpublish'])->name('about.unpublish');
    Route::get('/about/trash-view', action: [AboutsController::class, 'trashView'])->name('abouts.trash-view');
    Route::patch('/about/{id}/publish', [AboutsController::class, 'publish'])->name('about.publish');
    Route::patch('/about/{id}/unpublish', [AboutsController::class, 'unpublish'])->name('about.unpublish');

    Route::resource('sites', SiteManagerController::class);
    Route::resource('/tenants-agreements', TenantAgreementwithSystemController::class);
    Route::get('/tenant-agreements/trashed', [TenantAgreementwithSystemController::class, 'trash'])->name('tenants-agreements.trash');
    Route::get('/generateAgreementPDF-superadmin/{id}', [TenantAgreementwithSystemController::class, 'generateAgreementPDF'])->name('superadmin.generateAgreementPDF');
    Route::delete('/tenant-agreement/delete/{id}', [TenantAgreementwithSystemController::class, 'delete'])->name('tenant-agreements.delete');
    Route::get('/tenant-agreement/restore/{id}', [TenantAgreementwithSystemController::class, 'restore'])->name('tenant_agreement.restore');
    Route::patch('/tenant-agreement/{id}/verify', [TenantAgreementwithSystemController::class, 'verify'])->name('systemandtenant-agreements.verify');


    Route::resource('sliders', SliderImagesController::class);
    Route::get('slider/trash-view', action: [SliderImagesController::class, 'trashView'])->name('sliders.trash-view');
    Route::delete('slider/trash/{id}', [SliderImagesController::class, 'trashDelete'])->name('slider.trash');
    Route::delete('slider/{id}', [SliderImagesController::class, 'delete'])->name('slider.delete');
    Route::get('slider/restore/{id}', [SliderImagesController::class, 'restore'])->name('slider.restore');
    Route::patch('slider/{id}/publish', [SliderImagesController::class, 'publish'])->name('slider.publish');
    Route::patch('slider/{id}/unpublish', [SliderImagesController::class, 'unpublish'])->name('slider.unpublish');

    Route::resource('galleries', GalleryController::class);
    Route::get('gallery/trash-view', action: [GalleryController::class, 'trashView'])->name('galleries.trash-view');
    Route::delete('gallery/trash/{id}', [GalleryController::class, 'trashDelete'])->name('gallery.trash');
    Route::delete('gallery/{id}', [GalleryController::class, 'delete'])->name('gallery.delete');
    Route::get('gallery/restore/{id}', [GalleryController::class, 'restore'])->name('gallery.restore');
    Route::patch('gallery/{id}/publish', [GalleryController::class, 'publish'])->name('gallery.publish');
    Route::patch('gallery/{id}/unpublish', [GalleryController::class, 'unpublish'])->name('gallery.unpublish');
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
    Route::get('/generateAgreementPDF-admin/{id}', [TenantAgreementwithSystemController::class, 'generateAgreementPDF'])->name('admin.generateAgreementPDF');
    Route::patch('/agreement/{id}/update', [TenantAgreementwithSystemController::class, 'update_agreement'])->name('admin.agreement.update');

    Route::get('/get-subcategories/{categoryId}', [CategoriesController::class, 'getSubcategories']);

    /*Category */
    Route::resource('categories', CategoriesController::class);
    Route::get('/category/trash-view', action: [CategoriesController::class, 'trashView'])->name('category.trash-view');
    Route::delete('/category/trash/{id}', [CategoriesController::class, 'trashDelete'])->name('category.trash');
    Route::get('/category/restore/{id}', [CategoriesController::class, 'restore'])->name('category.restore');
    Route::patch('/category/{id}/publish', [CategoriesController::class, 'publish'])->name('category.publish');
    Route::patch('/category/{id}/unpublish', [CategoriesController::class, 'unpublish'])->name('category.unpublish');

    // SubCategory
    Route::resource('subCategories', SubCategoriesController::class);
    Route::get('/subCategory/trash-view', action: [SubCategoriesController::class, 'trashView'])->name('subCategory.trash-view');
    Route::delete('/subCategory/trash/{id}', [SubCategoriesController::class, 'trashDelete'])->name('subCategory.trash');
    Route::get('/subCategory/restore/{id}', [SubCategoriesController::class, 'restore'])->name('subCategory.restore');
    Route::patch('/subCategory/{id}/publish', [SubCategoriesController::class, 'publish'])->name('subCategory.publish');
    Route::patch('/subCategory/{id}/unpublish', [SubCategoriesController::class, 'unpublish'])->name('subCategory.unpublish');

    //Products
    Route::resource('products', PropeertyController::class);
    Route::get('/product/trash-view', action: [PropeertyController::class, 'trashView'])->name('products.trash-view');
    Route::delete('/product/trash/{id}', [PropeertyController::class, 'trashDelete'])->name('product.trash');
    Route::get('/product/restore/{id}', [PropeertyController::class, 'restore'])->name('product.restore');
    Route::patch('/product/{id}/publish', [PropeertyController::class, 'publish'])->name('product.publish');
    Route::patch('/product/{id}/unpublish', [PropeertyController::class, 'unpublish'])->name('product.unpublish');
    Route::get('/product/images/{id}', [PropertyImagesController::class, 'index'])->name('products.images');
    Route::get('/product/review/{id}', [PropertyReviewController::class, 'showPropertyReviews'])->name('property.review');
    Route::delete('/product/review/delete/{id}', [PropertyReviewController::class, 'destroy'])->name('property.review.delete');
    Route::get('/product/message/{id}', [PropeertyController::class, 'message'])->name('property.contact');
    Route::delete('/product/message/delete/{id}', [PropeertyController::class, 'messageDelete'])->name('property.message.delete');
    Route::get('/property/payments/{id}', [PropeertyController::class, 'payments_details'])->name('property.payments');

    Route::resource('property-images', PropertyImagesController::class)->except('index');
    Route::get('/property-image/trash-view/{id}', action: [PropertyImagesController::class, 'trashView'])->name('property-images.trash-view');
    Route::delete('/property-image/trash/{id}', [PropertyImagesController::class, 'trashDelete'])->name('property-image.trash');
    Route::get('/property-image/restore/{id}', [PropertyImagesController::class, 'restore'])->name('property-image.restore');
    Route::patch('/property-image/{id}/publish', [PropertyImagesController::class, 'publish'])->name('property-image.publish');
    Route::patch('/property-image/{id}/unpublish', [PropertyImagesController::class, 'unpublish'])->name('property-image.unpublish');
});
