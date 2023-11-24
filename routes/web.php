<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\SystemControllerAdmin;
use App\Http\Controllers\SystemControllerUser;
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

    // Routes pro users
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user/edit', [UserController::class, 'editUserByAdmin'])->name('admin.user.edit');
    Route::get('/admin/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
    Route::post('/admin/user/editPassword', [UserController::class, 'editPasswordByAdmin'])->name('admin.user.password.edit');

    Route::get('/admin/systems', [SystemControllerAdmin::class, 'index'])->name('admin.systems');
    Route::post('/admin/systems/edit', [SystemControllerAdmin::class, 'edit'])->name('admin.system.edit');
    Route::post('/admin/systems/share', [SystemControllerAdmin::class, 'share'])->name('admin.system.share');
    Route::post('/admin/systems/create', [SystemControllerAdmin::class, 'create'])->name('admin.system.create');
    Route::get('/admin/systems/delete/{id}', [SystemControllerAdmin::class, 'destroy'])->name('admin.system.delete');

    Route::get('/admin/devices', [DeviceController::class, 'index'])->name('admin.devices');
    Route::post('/admin/devices/create', [DeviceController::class, 'create'])->name('admin.device.create');
    Route::get('/admin/devices/show/{encrypted_id}', [DeviceController::class, 'show'])->name('admin.device.show');
    Route::post('/admin/devices/edit/', [DeviceController::class, 'edit'])->name('admin.device.edit');
    Route::get('/admin/devices/delete/{id}', [DeviceController::class, 'destroy'])->name('admin.device.delete');

    Route::post('/admin/parameters/create/', [ParameterController::class, 'create'])->name('admin.parameters.create');
    Route::post('/admin/parameters/edit/', [ParameterController::class, 'edit'])->name('admin.parameters.edit');
    Route::get('/admin/parameters/delete/{id}', [ParameterController::class, 'destroy'])->name('admin.parameters.delete');
});

Route::group(['middleware' => 'basicUser'], function (){
    Route::get('/user/dashboard', [DashboardController::class, 'indexUser'])->name('user.dashboard');



    Route::get('/user/systems/my', [SystemControllerUser::class, 'indexMySystems'])->name('user.systems');
    Route::get('/user/systems/others', [SystemControllerUser::class, 'indexOtherSystems'])->name('user.systems.others');
    Route::get('/user/systems/sharedWithMe', [SystemControllerUser::class, 'indexSharedWithMe'])->name('user.systems.shared');

    Route::post('/user/systems/edit', [SystemControllerUser::class, 'edit'])->name('user.system.edit');
    Route::post('/user/systems/share', [SystemControllerUser::class, 'share'])->name('user.system.share');
    Route::get('/user/systems/shareRequest/{id}', [SystemControllerUser::class, 'shareRequest'])->name('user.system.share.request');
    Route::post('/user/systems/create', [SystemControllerUser::class, 'create'])->name('user.system.create');
    Route::get('/user/systems/delete/{id}', [SystemControllerUser::class, 'destroy'])->name('user.system.delete');
});

Route::group(['middleware' => 'sharedGroup'], function () {
    Route::get('/profile', [UserController::class, 'indexProfile'])->name('profile.index');
    Route::post('/profile/edit', [UserController::class, 'editUserByUser'])->name('profile.edit');
    Route::post('/profile/editPassword', [UserController::class, 'editPasswordByUser'])->name('password.edit');
    Route::post('/sharing-requests', [UserController::class, 'editPasswordByUser'])->name('sharing.request');       // TODO????

    Route::post('/sharing-requests/accept', [RequestsController::class, 'acceptShareRequest'])->name('sharing.request.accept');
    Route::get('/sharing-requests/deny/{id}', [RequestsController::class, 'denyShareRequest'])->name('sharing.request.deny');

});
