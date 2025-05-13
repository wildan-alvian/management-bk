<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAchievementController;
use App\Http\Controllers\StudentMisconductController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/app');
    }
    return redirect('/login');
});

// Authentication Routes
Auth::routes();

Route::get('/app', function () {
    return view('layout.index');
})->middleware('auth');

Route::get('/test-role', function () { 
    return Auth::user()->getAllPermissions()->pluck('name');
    // return Auth::user()->hasRole('Super Admin') ? 'Super Admin' : 'Not Super Admin'; 
});

Route::middleware(['auth'])->group(function () {
    Route::resource('notifications', NotificationController::class);
});

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'role:Super Admin|Admin'])->group(function () {
    Route::resource('admin', AdminController::class);
    Route::resource('counselors', GuruBkController::class);
});

Route::middleware(['auth', 'role:Super Admin|Admin|Guidance Counselor'])->group(function () {
    Route::resource('counseling', CounselingController::class);
    Route::resource('students', StudentController::class);
    Route::resource('student-achievements', StudentAchievementController::class);
    Route::resource('student-misconducts', StudentMisconductController::class);
});

// Individual permission routes
Route::get('/counselors', [GuruBkController::class, 'index'])
    ->middleware(['auth', 'permission:view-user'])->name('counselors.index');

Route::get('/counseling', [CounselingController::class, 'index'])
    ->middleware(['auth', 'permission:view-counseling'])->name('counseling.index');

Route::get('/counseling/create', [CounselingController::class, 'create'])
    ->middleware(['auth', 'permission:view-counseling'])->name('counseling.create');

Route::post('/counseling', [CounselingController::class, 'store'])
    ->middleware(['auth', 'permission:create-counseling'])->name('counseling.store');

Route::get('/counseling/{id}', [CounselingController::class, 'edit'])
    ->middleware(['auth', 'permission:view-counseling'])->name('counseling.edit');

Route::post('/counseling/{id}', [CounselingController::class, 'update'])
    ->middleware(['auth', 'permission:edit-counseling'])->name('counseling.update');

Route::get('/students', [StudentController::class, 'index'])
    ->middleware(['auth', 'permission:view-student'])->name('students.index');
