<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\SetLocale;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;


Route::get('/lang/{locale}', function ($locale) {
if (! in_array($locale, ['en', 'ar'])) {
    abort(400);
}

session(['locale' => $locale]);
return back();
})->name('lang.switch');

Route::middleware([
    SetLocale::class, // ضيف الميدل وير هنا
])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

    // راوت لصفحة الاقسام
    Route::get('/categories', function () {
        return view('categories.index');
    })->middleware(['auth', 'verified'])->name('categories.index');

    // راوت لصفحة المنتجات
    Route::get('/products', function () {
        return view(view: 'products.index');
    })->middleware(['auth', 'verified'])->name(name: 'products.index');

    // راوت لصفحة العملاء
    Route::get('/customers', function () {
        return view(view: 'customers.index');
    })->middleware(['auth', 'verified'])->name(name: 'customers.index');





    // باقي الراوتات...

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);



    Route::get('/categories/{id}/products', [ProductController::class, 'byCategory'])->name('categories.products');



});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
