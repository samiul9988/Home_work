<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[AuthController::class, 'index'])->name('login');
Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard');
//    Route::get('/dashboard',[HomeController::class,'index'])->name('home');
    Route::get('user/profile-edit',[\App\Http\Controllers\User\HomeController::class,'profileEdit'])->name('user.profile-edit');

    Route::post('user/user-update/{id}',[\App\Http\Controllers\User\HomeController::class,'profileUpdate'])->name('user.profile-update');
    Route::post('user/change-password/{id}',[\App\Http\Controllers\User\HomeController::class,'changePassword'])->name('user.change-password');

    //Employee leave
    Route::resource('employee-leave',\App\Http\Controllers\Employee\EmployeeLeaveController::class);

});
Route::middleware(['userRole:admin','auth'])->prefix('admin')->group(function(){
    //admin
    Route::get('home',[\App\Http\Controllers\Admin\HomeController::class,'index'])->name('admin.home');
});
Route::post('/logout',[AuthController::class,'logOut'])->name('logout');
