<?php
use App\Http\Controllers\QuestionController;

Route::get('questions/select', [QuestionController::class, 'selectCourse'])->name('questions.select');

Route::resource('questions', QuestionController::class);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
