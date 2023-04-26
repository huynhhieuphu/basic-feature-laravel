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
    Route::get('/create', [StudentController::class, 'create'])->name('create');
    Route::post('/', [StudentController::class, 'store'])->name('store');
    Route::get('/{student}/edit/', [StudentController::class, 'edit'])->name('edit');
    Route::match(['put','patch'],'/{student}', [StudentController::class, 'update'])->name('update');
    Route::get('/{student}', [StudentController::class, 'show'])->name('show');
    Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
});
