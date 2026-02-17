<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// dashboard utama
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth'])->name('dashboard');

// --- route: admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Buku
    Route::resource('books', BookController::class);

    // Kategori
    Route::resource('categories', CategoryController::class);

    // User
    Route::resource('users', UserController::class);

    // Peminjaman
    Route::get('admin/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('admin/borrowings/{id}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('admin/borrowings/{id}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::post('/borrowings/{id}/warning', [BorrowingController::class, 'giveWarning'])->name('borrowings.warning');
    Route::post('/borrowings/{id}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    // Laporan
    Route::get('admin/reports', [DashboardController::class, 'report'])->name('reports.index');
});

// --- role: siswa ---
Route::middleware(['auth', 'role:siswa'])->name('student.')->group(function () {

    Route::get('/student/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

    // Buku Student
    Route::get('student/books', [\App\Http\Controllers\Student\BookController::class, 'index'])->name('books.index');
    Route::get('student/books/{id}/borrow', [\App\Http\Controllers\Student\BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('student/books/{id}/borrow', [\App\Http\Controllers\Student\BorrowingController::class, 'store'])->name('borrowings.store');

    // Peminjaman Student
    Route::get('/student/my-borrowings', [\App\Http\Controllers\Student\BorrowingController::class, 'myBorrowings'])->name('borrowings.index');
    Route::get('/student/my-penalties', [\App\Http\Controllers\Student\BorrowingController::class, 'penalties'])->name('borrowings.penalties');
});

// --- public access ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
