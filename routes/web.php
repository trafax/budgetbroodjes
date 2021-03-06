<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Bedrijfskantine routes
 */
Route::middleware('web')->domain(config()->get('domain'))->group(function(){

    // Acties voor iedereen in de kantine
    Route::get('/canteen', [\App\Http\Controllers\HomeController::class, 'canteen'])->name('canteen');

    Route::get('canteen/category/{category}', [\App\Http\Controllers\CanteenController::class, 'category'])->name('canteen.category');

    // Acties voor de kantine beheerder
    Route::middleware(['role:owner'])->group(function () {
        //Route::get('/canteen', [\App\Http\Controllers\HomeController::class, 'canteen'])->name('canteen');
        Route::get('canteen/dashboard', [\App\Http\Controllers\CanteenController::class, 'dashboard'])->name('canteen.dashboard');

        Route::resource('employee', \App\Http\Controllers\EmployeeController::class)->except(['show', 'destroy']);
        Route::get('employee/search', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.search');
        Route::get('employee/{employee}/destroy', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee.destroy');
    });

    // Acties voor de kantine gebruiker
    Route::middleware(['role:user'])->group(function () {

        Route::post('cart/{product}/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
        Route::post('cart/{product}/insert', [\App\Http\Controllers\CartController::class, 'insert'])->name('cart.insert');
    });

});


Auth::routes(['logout' => false]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::middleware(['role:admin'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('company', \App\Http\Controllers\CompanyController::class)->except(['show', 'destroy']);
    Route::get('company/search', [\App\Http\Controllers\CompanyController::class, 'index'])->name('company.search');
    Route::get('company/{company}/destroy', [\App\Http\Controllers\CompanyController::class, 'destroy'])->name('company.destroy');

    Route::resource('user', \App\Http\Controllers\UserController::class)->except(['show', 'destroy']);
    Route::get('user/search', [\App\Http\Controllers\UserController::class, 'index'])->name('user.search');
    Route::get('user/{user}/destroy', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');

    Route::get('foodticket', [\App\Http\Controllers\FoodticketController::class, 'index'])->name('foodticket.index');
    Route::get('foodticket/sync_categories', [\App\Http\Controllers\FoodticketController::class, 'sync_categories'])->name('foodticket.sync_categories');
    Route::get('foodticket/sync_products', [\App\Http\Controllers\FoodticketController::class, 'sync_products'])->name('foodticket.sync_products');
    Route::get('foodticket/sync_extras', [\App\Http\Controllers\FoodticketController::class, 'sync_extras'])->name('foodticket.sync_extras');
    Route::get('foodticket/sync_images', [\App\Http\Controllers\FoodticketController::class, 'sync_images'])->name('foodticket.sync_images');

    Route::resource('category', \App\Http\Controllers\CategoryController::class)->except(['show', 'destroy']);
    Route::get('category/search', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.search');
    Route::get('category/{category}/destroy', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');

    Route::resource('product', \App\Http\Controllers\ProductController::class)->except(['show', 'destroy']);
    Route::get('product/search', [\App\Http\Controllers\ProductController::class, 'index'])->name('product.search');
    Route::get('product/{product}/destroy', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
});
