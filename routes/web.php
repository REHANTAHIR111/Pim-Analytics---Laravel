<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SubtagController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.submit');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::middleware('auth')->group(function () {
    Route::view('/', 'index')->name('index');
    Route::prefix('pim')->name('pim.')->group(function () {
        Route::post('upload', [UploadController::class, 'handle']);
        Route::controller(RoleController::class)->prefix('role')->name('role.')->group(function () {
            Route::get('/', 'index')->name('listing');
            Route::get('add', 'create')->name('add');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
        Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
            Route::get('/', 'index')->name('listing');
            Route::get('add', 'create')->name('add');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
        Route::controller(FaqController::class)->prefix('productFaqs')->name('productFaqs.')->group(function () {
            Route::get('/', 'index')->name('listing');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
        Route::controller(TagController::class)->prefix('tags')->name('tags.')->group(function () {
            Route::get('/', 'index')->name('listing');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
        Route::controller(SubtagController::class)->prefix('subtags')->name('tags.subtags.')->group(function () {
            Route::get('/{id}', 'index')->name('listing');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
        Route::controller(CategoriesController::class)->prefix('categories')->name('categories.')->group(function () {
            Route::get('/', 'index')->name('listing');
            Route::get('add', 'create')->name('add');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
        Route::controller(BrandController::class)->prefix('brand')->name('brand.')->group(function () {
            Route::get('/', 'index')->name('listing');
            Route::get('add', 'create')->name('add');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
        Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
            Route::get('/', 'index')->name('listing');
            Route::get('add', 'create')->name('add');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::get('view/{id}', 'view')->name('view');
            Route::get('delete/{id}', 'delete')->name('delete');
            Route::post('bulk-delete', 'multiDelete')->name('bulk-delete');
        });
    });

});
