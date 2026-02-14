<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/switch-language/{locale}', [LanguageController::class, 'switch'])
    ->name('switch.language');

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', [FilmController::class, 'index'])->name('films.index');
    Route::get('/show-film/{id}', [FilmController::class, 'showView'])->name('films.showView');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.home');
        })->name('admin.home');

        Route::get('/create-film', [FilmController::class, 'createView'])->name('films.createView');
        Route::get('/edit-film/{id}', [FilmController::class, 'editView'])->name('films.editView');
        Route::post('/create-film', [FilmController::class, 'create'])->name('films.create');
        Route::put('/edit-film/{id}', [FilmController::class, 'edit'])->name('films.edit');
        Route::delete('/delete-film/{film}', [FilmController::class, 'destroy'])->name('films.destroy');

        Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
        Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create');
        Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
        Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    });
});
