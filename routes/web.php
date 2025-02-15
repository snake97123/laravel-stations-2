<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AdminReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('practice', function() {
//     return response('practice');
// });

// Route::get('practice2', function() {
//         $test = 'practice2';
//     return response($test);
// });

// Route::get('practice3', function() {
//         $test = app()->version();
//     return response($test);
// });

// Station2の内容
Route::get('practice', [PracticeController::class, 'sample']);
Route::get('practice2', [PracticeController::class, 'sample2']);
Route::get('practice3', [PracticeController::class, 'sample3']);

// Station3の内容
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

// Station6の内容
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

// Station7の内容
Route::get('/admin/movies',[AdminMovieController::class, 'index']);
Route::get('/admin/movies/create', [AdminMovieController::class, 'create'])->name('movies.create');
Route::get('/admin/movies/{id}', [AdminMovieController::class, 'show'])->name('movies.show');
Route::get('/admin/movies/{id}/schedules/create', [AdminScheduleController::class, 'create'])->name('schedules.create');
Route::post('/admin/movies/{id}/schedules/store', [AdminScheduleController::class, 'store'])->name('schedules.store');

// Station8の内容
Route::post('/admin/movies/store', [AdminMovieController::class, 'store'])->name('movies.store');

// Station9の内容
Route::get('/admin/movies/{id}/edit', [AdminMovieController::class, 'edit'])->name('movies.edit');
Route::patch('/admin/movies/{id}/update', [AdminMovieController::class, 'update'])->name('movies.update');

// Station10の内容
Route::delete('/admin/movies/{id}/destroy', [AdminMovieController::class, 'delete'])->name('movies.destroy');

// Station13の内容
Route::get('/sheets', [SheetController::class, 'index'])->name('sheets.index');

// Station14の内容
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie_id}/schedules/{schedule_id}/sheets', [SheetController::class, 'show'])->name('sheets.show');
Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create', [SheetController::class, 'create'])->name('sheets.create');
Route::post('/reservations/store', [SheetController::class, 'store'])->name('reservations.store');

// Station15の内容
Route::get('/admin/schedules', [AdminScheduleController::class, 'index'])->name('schedules.index');
Route::get('/admin/schedules/{id}', [AdminScheduleController::class, 'show'])->name('admin.movies.show');
Route::get('/admin/schedules/{scheduleId}/edit', [AdminScheduleController::class, 'edit'])->name('schedules.edit');
Route::patch('/admin/schedules/{id}/update', [AdminScheduleController::class, 'update'])->name('schedules.update');

Route::delete('admin/schedules/{scheduleId}/destroy', [AdminScheduleController::class, 'delete'])->name('schedules.destroy');

// Station19の内容
Route::get('/admin/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
Route::get('/admin/reservations/create', [AdminReservationController::class, 'create'])->name('reservations.create');
Route::post('/admin/reservations/', [AdminReservationController::class, 'store'])->name('admin.reservations.store');
Route::get('/admin/reservations/schedules/{movie_id}', [AdminReservationController::class, 'getSchedules']);
Route::get('/admin/reservations/{id}/edit', [AdminReservationController::class, 'show'])->name('reservations.show');
Route::patch('/admin/reservations/{id}/', [AdminReservationController::class, 'update'])->name('reservations.update');
Route::delete('/admin/reservations/{id}', [AdminReservationController::class, 'delete'])->name('reservations.destroy');