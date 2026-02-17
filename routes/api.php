<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BorrowingController;
use App\Http\Controllers\Api\LibraryController;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Books
Route::get('/books', [LibraryController::class, 'getBooks']);
Route::get('/books/{id}', [LibraryController::class, 'getBookDetail']);

// Categories
Route::get('/categories', [LibraryController::class, 'getCategories']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Protected Routes (Supaya tidak boleh orang yang gapunya token masuk)
Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::get('/user', [AuthController::class, 'profile']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Borrowing/Peminjaman
    Route::get('/borrowings', [BorrowingController::class, 'index']);
    Route::get('/borrowings/{id}', [BorrowingController::class, 'show']);
    Route::post('/borrowings', [BorrowingController::class, 'store']);
});
