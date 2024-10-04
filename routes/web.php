<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\InventoryController;
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

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::resource('category', CategoryController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::resource('students', StudentController::class);
Route::post('/students/{student}/update-photo', [StudentController::class, 'updatePhoto'])->name('students.updatePhoto');
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::resource('materials', MaterialController::class);
Route::post('/materials/{material}/update-photo', [MaterialController::class, 'updatePhoto'])->name('materials.updatePhoto');
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::resource('departments', DepartmentController::class);
Route::post('/departments/{departamento}/update-photo', [DepartmentController::class, 'updatePhoto'])->name('departments.updatePhoto');
Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
Route::resource('inventories', InventoryController::class);
Route::post('/inventories/{inventory}/update-photo', [InventoryController::class, 'updatePhoto'])->name('inventories.updatePhoto');
