<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
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

// === PUBLIC ROUTES ===
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/course/{course:slug}', [PublicController::class, 'show'])->name('course.show');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// === AUTH ROUTES ===
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === SISWA ===
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('my.courses');
    Route::post('/course/{course}/join', [StudentController::class, 'enroll'])->name('course.join');
    Route::get('/learning/{course:slug}', [StudentController::class, 'index'])->name('learning.index');
    Route::get('/learning/{course:slug}/{contentId}', [StudentController::class, 'index'])->name('learning.content');
    Route::post('/learning/{course:slug}/{content}/complete', [StudentController::class, 'complete'])->name('learning.complete');

    // === ADMIN & TEACHER ===
    Route::prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('courses', CourseController::class);
        Route::get('/courses/{course}/students', [CourseController::class, 'students'])->name('courses.students');
        Route::resource('courses.contents', ContentController::class);
    });
});

require __DIR__.'/auth.php';