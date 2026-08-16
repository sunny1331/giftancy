<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\ProductVariantController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::resource('categories', CategoryController::class);

    Route::get(
        'categories/{category}/attributes',
        [\App\Http\Controllers\Admin\CategoryAttributeController::class, 'index']
    )->name('categories.attributes');

    Route::post(
        'categories/{category}/attributes',
        [\App\Http\Controllers\Admin\CategoryAttributeController::class, 'store']
    )->name('categories.attributes.store');

    Route::resource('attributes', \App\Http\Controllers\Admin\AttributeController::class);

    Route::resource('attribute-values', \App\Http\Controllers\Admin\AttributeValueController::class);

    Route::resource('products', ProductController::class);

    Route::get(
    'products/category/{category}/attributes',
    [ProductController::class, 'getCategoryAttributes']
)->name('products.category.attributes');

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::delete(
'/admin/product-images/{image}',
[\App\Http\Controllers\Admin\ProductImageController::class,'destroy']
)->name('product-images.destroy');

Route::prefix('products')->group(function () {

    Route::get(
        '/{product}/variants',
        [ProductVariantController::class, 'index']
    )->name('products.variants.index');

    Route::get(
        '/{product}/variants/create',
        [ProductVariantController::class, 'create']
    )->name('products.variants.create');

    Route::post(
        '/{product}/variants',
        [ProductVariantController::class, 'store']
    )->name('products.variants.store');

    Route::get(
        '/variants/{variant}/edit',
        [ProductVariantController::class, 'edit']
    )->name('products.variants.edit');

    Route::put(
        '/variants/{variant}',
        [ProductVariantController::class, 'update']
    )->name('products.variants.update');

    Route::delete(
        '/variants/{variant}',
        [ProductVariantController::class, 'destroy']
    )->name('products.variants.destroy');

});

require __DIR__.'/auth.php';