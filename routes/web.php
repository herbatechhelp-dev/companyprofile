<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;

Route::get('/', [PageController::class, 'home'])->name('home');

// Articles
Route::get('/articles/{category}', [PageController::class, 'articles'])->name('articles.category');
Route::get('/articles/{category}/{slug}', [PageController::class, 'articleDetail'])->name('articles.detail');

// Company Pages
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about');
Route::get('/our-company/{page}', [PageController::class, 'companyPage'])->name('company.page');

// Industry/Products
Route::get('/industry', [PageController::class, 'industry'])->name('industry');
Route::get('/products/{slug}', [PageController::class, 'productDetail'])->name('products.detail');

// Contact
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities');
Route::get('/facilities/{slug}', [PageController::class, 'facilityDetail'])->name('facilities.detail');

// Career / Vacancies
Route::get('/career', [\App\Http\Controllers\VacancyController::class, 'index'])->name('career');
Route::get('/career/{slug}', [\App\Http\Controllers\VacancyController::class, 'detail'])->name('career.detail');
