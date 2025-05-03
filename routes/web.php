<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAchievementController;
use App\Http\Controllers\StudentMisconductController;
use App\Http\Controllers\CounselingController;




Route::get('/', function () {
    return view('welcome');
});
Route::get('/user', function () {
    return view('welcome');
});
Route::get('/app', function () {
    return view('layout.index');
});
Route::resource('admin', AdminController::class);
Route::get('/guru', function () {
    return redirect()->route('guru-bk.index');
});
Route::resource('guru-bk', GuruBkController::class);
Route::resource('student', StudentController::class);
Route::resource('achievement', StudentAchievementController::class);
Route::post('/achievements', [StudentAchievementController::class, 'store'])->name('achievement.store');
Route::resource('misconduct', StudentMisconductController::class);
Route::resource('counseling', CounselingController::class);
