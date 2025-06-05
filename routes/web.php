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

    Route::get('/error-404', 'error_404')->name('error.404');
    Route::get('/error.403', 'error_403')->name('error.403');
    Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
        Route::get('/user-logout', 'user_logout')->name('user.logout');
    });
});



Route::controller(BackendController::class)->group(function () {
    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/admin-logout', 'admin_logout')->name('admin.logout');
        Route::get('/add-category', 'add_category')->name('add.category');
        Route::post('/add-category/store', 'add_category_store')->name('add.category.store');
        Route::get('/category', 'category')->name('category');
        Route::get('/category-edit/{id}', 'category_edit')->name('category.edit');
        Route::put('/category/updated', 'category_updated')->name('category.updated');
        Route::post('/category/delete', 'category_delete')->name('category.delete');

        Route::get('/add-product', 'add_product')->name('add.product');
        Route::post('/product/store', 'add_product_store');
    });
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
