<?php

use App\Http\Controllers\Admin\CohortController;
use App\Http\Controllers\Admin\CreboController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.layoutpublic');
});

Route::get('/admin', function () {
    return view('layouts.layoutadmin');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/crebos/{crebo}/delete', [CreboController::class, 'delete'])->name('crebos.delete');
    Route::resource('crebos', CreboController::class);

    Route::get('/cohorts/{cohort}/delete', [CohortController::class, 'delete'])->name('cohorts.delete');
    Route::resource('cohorts', CohortController::class);

    Route::get('/statuses/{status}/delete', [StatusController::class, 'delete'])->name('statuses.delete');
    Route::resource('statuses', StatusController::class);

    Route::get('/students/{student}/delete', [StudentController::class, 'delete'])->name('students.delete');
    Route::resource('students', StudentController::class);
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
