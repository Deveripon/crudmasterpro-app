<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


Route::get('student',[StudentController::class,'index']) -> name('student.index');
Route::get('student-create',[StudentController::class,'create']) -> name('student.create');
Route::post('student',[StudentController::class,'store']) -> name('student.store');