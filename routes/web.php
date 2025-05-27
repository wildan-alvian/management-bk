<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentParentController;
use App\Http\Controllers\StudentAchievementController;
use App\Http\Controllers\StudentMisconductController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// Authentication Routes
Auth::routes([
    'register' => false,
    'reset' => false,
]);

// Custom Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Change Password Routes
Route::get('password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'showChangePasswordForm'])
    ->name('password.change');
Route::post('password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'changePassword']);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('notifications', NotificationController::class);
    Route::get('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notification.read');
    
});

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'role:Super Admin|Admin'])->group(function () {
    Route::resource('admin', AdminController::class);
    Route::get('/students/parents', [StudentController::class, 'getStudentParents'])->name('students.parents');
});

Route::middleware(['auth', 'role:Guidance Counselor'])->group(function () {
    Route::post('/counseling/{counseling}/approve', [CounselingController::class, 'approve'])->name('counseling.approve');
    Route::post('/counseling/{counseling}/reject', [CounselingController::class, 'reject'])->name('counseling.reject');
    Route::post('/counseling/{counseling}/cancel', [CounselingController::class, 'cancel'])->name('counseling.cancel');
});

Route::middleware(['auth', 'role:Super Admin|Admin|Guidance Counselor'])->group(function () {
    Route::resource('counselors', GuruBkController::class);
    Route::resource('counseling', CounselingController::class);
    Route::resource('students', StudentController::class)->except(['index', 'show']);
    Route::resource('student-parents', StudentParentController::class)->except(['index', 'show']);
    Route::resource('student-achievements', StudentAchievementController::class);
    Route::resource('student-misconducts', StudentMisconductController::class);
    Route::get('/students/{student}/export-pdf', [StudentController::class, 'exportPdf'])->name('students.exportPdf');
});

// Student viewing routes with broader access
Route::middleware(['auth', 'role:Super Admin|Admin|Guidance Counselor|Student|Student Parents'])->group(function () {
    Route::get('/student-parents', [StudentParentController::class, 'index'])->name('student-parents.index');
    Route::get('/student-parents/{id}', [StudentParentController::class, 'show'])->name('student-parents.show');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/counseling/{counseling}', [CounselingController::class, 'show'])->name('counseling.show');
});

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