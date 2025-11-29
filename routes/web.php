<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT SEMUA CONTROLLER (WAJIB ADA) ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;       // <--- PENTING
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. AREA PUBLIK (Bisa diakses TANPA LOGIN)
// ====================================================

// Homepage
Route::get('/', [PublicController::class, 'index'])->name('home');

// Detail Kursus
Route::get('/course/{course:slug}', [PublicController::class, 'show'])->name('course.show');

// --- RUTE REGISTER & LOGIN ---
// Register (Menampilkan Form)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Register (Proses Simpan Data) - INI YANG TADI ERROR
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Login (Bawaan Breeze biasanya sudah ada di auth.php, tapi kita definisikan ulang jika perlu custom)
// (Biarkan route login bawaan dari require auth.php di bawah menangani login)


// ====================================================
// 2. AREA AUTH (Harus LOGIN dulu)
// ====================================================
Route::middleware('auth')->group(function () {

    // Logout Khusus
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- FITUR SISWA ---
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('my.courses');
    Route::post('/course/{course}/join', [StudentController::class, 'enroll'])->name('course.join');
    
    // Learning System
    Route::get('/learning/{course:slug}', [StudentController::class, 'index'])->name('learning.index');
    Route::get('/learning/{course:slug}/{contentId}', [StudentController::class, 'index'])->name('learning.content');
    Route::post('/learning/{course:slug}/{content}/complete', [StudentController::class, 'complete'])->name('learning.complete');

    // --- FITUR ADMIN & TEACHER ---
    Route::prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('courses', CourseController::class);
        Route::get('/courses/{course}/students', [CourseController::class, 'students'])->name('courses.students');
        Route::resource('courses.contents', ContentController::class);
    });
});

// Memuat route otentikasi bawaan Breeze (Login, Reset Password, dll)
require __DIR__.'/auth.php';