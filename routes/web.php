<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('students.index'));

Route::delete('students/bulk-destroy', [StudentController::class, 'bulkDestroy'])
    ->name('students.bulk-destroy');

Route::resource('students', StudentController::class)->except(['show']);