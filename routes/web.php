<?php

use App\Http\Controllers\Management\BranchController;
use App\Http\Controllers\Management\RatingController;
use App\Http\Controllers\Management\SubjectController;
use App\Http\Controllers\Management\TrainingController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Management\YearController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\TeacherChartComponent;
use Livewire\Livewire;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('subjects', SubjectController::class);
Route::resource('trainings', TrainingController::class);
Route::resource('users', UserController::class);
Route::resource('years', YearController::class);
Route::resource('branches', BranchController::class);
Route::resource('ratings', RatingController::class);
Route::get('/admin/users/{user}/report', [UserController::class, 'report'])->name('users.report');

Route::
get('users/{id}/whatsapp', [UserController::class, 'whatsapp'])->name('users.whatsapp');
