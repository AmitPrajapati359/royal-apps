<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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

// Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');

    Route::post('/authors/search', [AuthorController::class, 'search'])->name('authors.search');

    Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
});
