<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/switch-language/{locale}', [LanguageController::class, 'switch'])
    ->name('switch.language');

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', [FilmController::class, 'index'])->name('films.index');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('auth.login');


    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.home');
        })->name('admin.home');
    });
});
