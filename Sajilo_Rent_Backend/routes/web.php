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
Route::get('/register', [AuthController::class, 'register'])->name('register'); // Route::get('/register', [FrontendController::class, 'register'] )
Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-details/{id}', [FrontendController::class, 'blog_details'])->name('blog_details');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/product/{categoryId}/{subcategoryId}', [FrontendController::class, 'product'])->name('product');





