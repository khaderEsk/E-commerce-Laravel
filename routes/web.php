<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;






Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::post('/user/login', 'login_user')->name('login');
    Route::post('/create-account', 'create_account')->name('register');
    Route::get('/user/forget-password', 'forget_password')->name('forget.password');
    Route::post('/user/reset-password', 'reset_password')->name('reset.password');
    Route::get('/user/update-password/{id}', 'update_password')->name('update.password');
    Route::get('/super-deals', 'super_deals')->name('super.deals');
    Route::get('/products-all', 'products')->name('products');

    Route::get('/products-by-category/{id}', 'products_by_category')->name('products.by.category');
    Route::get('/product-view/{id}', 'product_view')->name('product.view');

    Route::post('/search-products', 'search_products');
    Route::post('/search-view/{products}', 'search_view');


    Route::get('/error-404', 'error_404')->name('error.404');
    Route::get('/error-403', 'error_403')->name('error.403');

    Route::post('/add-cart', 'add_cart')->name('add.cart');
    Route::get('/view-cart', 'view_cart')->name('view.cart');
    Route::post('/cart-delete', 'cart_delete')->name('cart.delete');
    Route::get('/empty-cart', 'empty_cart');
    Route::post('/add-wishlist', 'add_order_wishlist')->name('add.order.wishlist');


    Route::post('/add-favorite', 'add_favorite')->name('add.favorite');
    Route::get('/view-favorite', 'view_favorite')->name('view.favorite');
    Route::post('/add-favorite-cart', 'add_favorite_cart');
    Route::delete('/favorite-delete/{id}', 'favorite_delete')->name('favorite.delete');
    Route::get('/empty-wishlist', 'empty_wishlist');

    Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
        Route::get('/user-logout', 'user_logout')->name('user.logout');
    });
});



Route::controller(BackendController::class)->group(function () {
    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/add-category', 'add_category')->name('add.category');
        Route::post('/add-category/store', 'add_category_store')->name('add.category.store');
        Route::get('/category', 'category')->name('category');
        Route::get('/category-edit/{id}', 'category_edit')->name('category.edit');
        Route::post('/category/updated', 'category_updated')->name('category.updated');
        Route::post('/category/delete', 'category_delete')->name('category.delete');

        Route::get('/add-product', 'add_product')->name('add.product');
        Route::post('/product/store', 'add_product_store');
        Route::get('/view-product', 'product_view')->name('view.product');
        Route::get('/product-edit/{id}', 'product_edit')->name('product.edit');
        Route::post('/product/updated', 'product_updated')->name('product.updated');
        Route::get('/product/delete/{id}', 'product_delete')->name('product.delete');

        Route::get('/Featured/Products/add', 'Featured_Products_add')->name('Featured.Products.add');
        Route::post('/product/featured/store', 'product_featured_store')->name('product.featured.store');

        Route::get('/Featured/Products/view', 'Featured_Products_view')->name('Featured.Products.view');
        Route::get('/admin-logout', 'admin_logout')->name('admin.logout');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
