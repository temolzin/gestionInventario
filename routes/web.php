<?php

use App\Http\Controllers\CategoriesController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::resource('categories', CategoriesController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::resource('students', StudentController::class);
Route::post('/students/{student}/update-photo', [StudentController::class, 'updatePhoto'])->name('students.updatePhoto');
