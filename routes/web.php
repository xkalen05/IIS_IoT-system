<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('starter');
});

Auth::routes();

Route::get('/home', function (){
    return match (Auth::user()->role){
      'admin' => redirect(\route('admin.dashboard')),
      'basic_user' => redirect(route('user.dashboard')),
    };
})->middleware('auth')->name('home');

Route::group(['middleware' => 'adminUser'], function (){
    Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::get('/admin/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
    Route::post('/admin/user/editPassword', [UserController::class, 'editPassword'])->name('admin.user.password.edit');

    Route::get('/admin/systems', [SystemController::class, 'index'])->name('admin.systems');
    Route::get('/admin/systems/show/{id}', [SystemController::class, 'show'])->name('admin.systems.show');
    Route::post('/admin/systems/edit', [SystemController::class, 'edit'])->name('admin.system.edit');
    Route::post('/admin/systems/share', [SystemController::class, 'share'])->name('admin.system.share');
    Route::post('/admin/systems/create', [SystemController::class, 'create'])->name('admin.system.create');
    Route::get('/admin/systems/delete/{id}', [SystemController::class, 'destroy'])->name('admin.system.delete');

    Route::get('/admin/devices', [DeviceController::class, 'index'])->name('admin.devices');
    Route::get('/admin/devices/show/{id}', [DeviceController::class, 'show'])->name('admin.device.show');
    Route::get('/admin/devices/edit/{id}', [DeviceController::class, 'edit'])->name('admin.device.edit');
    Route::get('/admin/devices/delete/{id}', [DeviceController::class, 'destroy'])->name('admin.device.delete');
});

Route::group(['middleware' => 'basicUser'], function (){
    Route::get('/user/dashboard', [DashboardController::class, 'indexUser'])->name('user.dashboard');
});
