<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('category', CategoryController::class);
    Route::resource('students', StudentController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('inventories', InventoryController::class);

    Route::post('/students/{student}/update-photo', [StudentController::class, 'updatePhoto'])->name('students.updatePhoto');
    Route::post('/materials/{material}/update-photo', [MaterialController::class, 'updatePhoto'])->name('materials.updatePhoto');
    Route::post('/users/{user}/update-photo', [UserController::class, 'updatePhoto'])->name('users.updatePhoto');
    Route::put('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
    Route::post('/departments/{departamento}/update-photo', [DepartmentController::class, 'updatePhoto'])->name('departments.updatePhoto');
});
