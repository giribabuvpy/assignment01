<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/logout',[UserController::class,'logout']);


// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', CheckRole::class.':admin']], function () { 
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('sub-category', App\Http\Controllers\Admin\SubCategoryController::class);
    Route::resource('expenses', App\Http\Controllers\Admin\UserExpensesController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/logout', [AdminController::class,'logout'])->name('admin.logout');
});

Route::get('admin/login', [AdminController::class,'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class,'login'])->name('admin.login.submit');

// User routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/addexpense',[App\Http\Controllers\HomeController::class, 'addexpenses'])->name('expense.add');
    Route::post('/store',[App\Http\Controllers\HomeController::class, 'store'])->name('expense.store');
    Route::delete('/destroy',[App\Http\Controllers\HomeController::class, 'destroy'])->name('expense.destroy'); 
    Route::get('/sub-categories/{category}', [App\Http\Controllers\HomeController::class, 'getsubcategory'])->name('getsubcategory');
    
});




