<?php

use App\Http\Controllers\Admin\CanvasSettingController;
use App\Http\Controllers\Admin\CanvasTestController;
use App\Http\Controllers\Admin\CohortController;
use App\Http\Controllers\Admin\CreboController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SchoolYearController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\CanvasController;
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
    Route::get('/students/{student}/find-canvas-id', [StudentController::class, 'findCanvasId'])->name('students.find-canvas-id');
    Route::resource('students', StudentController::class);

    Route::get('/school-years/{school_year}/delete', [SchoolYearController::class, 'delete'])->name('school-years.delete');
    Route::resource('school-years', SchoolYearController::class);

    Route::get('/school-classes/{school_class}/delete', [SchoolClassController::class, 'delete'])->name('school-classes.delete');
    Route::resource('school-classes', SchoolClassController::class);

    Route::get('/canvas-settings/{canvas_setting}/delete', [CanvasSettingController::class, 'delete'])->name('canvas-settings.delete');
    Route::resource('canvas-settings', CanvasSettingController::class);

    Route::get('/enrollments/{enrollment}/delete', [EnrollmentController::class, 'delete'])->name('enrollments.delete');
    Route::resource('enrollments', EnrollmentController::class);

    Route::get('/test-canvas-api', [StudentController::class, 'testCanvasApi'])->name('test-canvas-api');
    // Canvas test routes
    Route::prefix('canvas-test')->name('canvas-test.')->group(function () {
        Route::get('/', [CanvasTestController::class, 'index'])->name('index');
        Route::get('/connection', [CanvasTestController::class, 'testConnection'])->name('connection');
        Route::get('/find-canvas-id', [CanvasTestController::class, 'testFindCanvasId'])->name('find-canvas-id');
        Route::post('/find-canvas-id', [CanvasTestController::class, 'testFindCanvasId']);
        Route::get('/batch-find-canvas-ids', [CanvasTestController::class, 'testBatchFindCanvasIds'])->name('batch-find-canvas-ids');
        Route::post('/batch-find-canvas-ids', [CanvasTestController::class, 'testBatchFindCanvasIds']);
        Route::get('/courses', [CanvasTestController::class, 'showCourses'])->name('courses');
    });
});
Route::prefix('canvas')->name('canvas.')->group(function () {
    Route::get('/test', [CanvasController::class, 'testConnection'])->name('test');
    Route::get('/courses', [CanvasController::class, 'listCourses'])->name('courses');
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
