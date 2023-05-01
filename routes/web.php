<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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

Route::prefix('/student')->name('student.')->group(function() {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::post('/', [StudentController::class, 'store'])->name('store');
    Route::get('/fetch-data', [StudentController::class, 'fetch'])->name('fetch');
    Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [StudentController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [StudentController::class, 'delete'])->name('delete');
    Route::post('/{id}/destroy', [StudentController::class, 'destroy'])->name('destroy');
});
