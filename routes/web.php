<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\SystemControllerAdmin;
use App\Http\Controllers\SystemControllerUser;
use App\Http\Controllers\UnregistredUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\DeviceControllerUser;
use App\Http\Controllers\BrokerController;

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

//Route::get('/', function () {
//    return view('starter');
//});
Route::get('/', [UnregistredUserController::class, 'index'])->name('unregistred.index');

Auth::routes();

Route::get('/home', function (){
    return match (Auth::user()->role){
        'admin' => redirect(\route('admin.systems')),
        'basic_user' => redirect(route('user.systems')),
        'broker' => redirect(\route('broker.index')),
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
    Route::get('/admin/systems/{system}', [SystemControllerAdmin::class, 'show'])->name('admin.system.show');

    Route::get('/admin/devices', [DeviceController::class, 'index'])->name('admin.devices');
    Route::post('/admin/devices/create', [DeviceController::class, 'create'])->name('admin.device.create');
    Route::get('/admin/devices/show/{encrypted_id}', [DeviceController::class, 'show'])->name('admin.device.show');
    Route::post('/admin/devices/edit/', [DeviceController::class, 'edit'])->name('admin.device.edit');
    Route::post('/admin/devices/reserve/', [DeviceController::class, 'reserve'])->name('admin.device.reserve');
    Route::get('/admin/devices/free/{id}', [DeviceController::class, 'free'])->name('admin.device.free');
    Route::get('/admin/devices/delete/{id}', [DeviceController::class, 'destroy'])->name('admin.device.delete');

    Route::post('/admin/parameters/create', [ParameterController::class, 'create'])->name('admin.parameters.create');
    Route::post('/admin/parameters/edit', [ParameterController::class, 'edit'])->name('admin.parameters.edit');
    Route::get('/admin/parameters/delete/{id}', [ParameterController::class, 'destroy'])->name('admin.parameters.delete');

    Route::get('/admin/kpis', [KPIController::class, 'index'])->name('admin.kpis');
    Route::post('/admin/kpis/create', [KPIController::class, 'create'])->name('admin.kpis.create');
    Route::post('/admin/kpis/edit', [KPIController::class, 'edit'])->name('admin.kpis.edit');
    Route::get('/admin/kpis/delete/{id}', [KPIController::class, 'destroy'])->name('admin.kpis.delete');

    Route::get('/admin/broker',[BrokerController::class, 'index'])->name('admin.broker.index');
    Route::post('/admin/broker/edit', [BrokerController::class, 'edit'])->name('admin.broker.edit');
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
    Route::get('/user/systems/{system}', [SystemControllerUser::class, 'show'])->name('user.system.show');
    Route::get('/user/systems/shared/{system}', [SystemControllerUser::class, 'showShared'])->name('user.system.showShared');

    Route::get('/user/devices', [DeviceControllerUser::class, 'index'])->name('user.devices');
    Route::post('/user/devices/create', [DeviceController::class, 'create'])->name('user.device.create');
    Route::get('/user/devices/show/{encrypted_id}', [DeviceControllerUser::class, 'show'])->name('user.device.show');
    Route::post('/user/devices/edit', [DeviceController::class, 'edit'])->name('user.device.edit');
    Route::get('/user/devices/delete/{id}', [DeviceController::class, 'destroy'])->name('user.device.delete');
    Route::post('/user/devices/reserve/', [DeviceController::class, 'reserve'])->name('user.device.reserve');
    Route::get('/user/devices/free/{id}', [DeviceController::class, 'free'])->name('user.device.free');

    Route::post('/user/parameters/create', [ParameterController::class, 'create'])->name('user.parameters.create');
    Route::post('/user/parameters/edit', [ParameterController::class, 'edit'])->name('user.parameters.edit');
    Route::get('/user/parameters/delete/{id}', [ParameterController::class, 'destroy'])->name('user.parameters.delete');

    Route::get('/user/kpis', [KPIController::class, 'index'])->name('user.kpis');
    Route::post('/user/kpis/create', [KPIController::class, 'create'])->name('user.kpis.create');
    Route::post('/user/kpis/edit/', [KPIController::class, 'edit'])->name('user.kpis.edit');
    Route::get('/user/kpis/delete/{id}', [KPIController::class, 'destroy'])->name('user.kpis.delete');
});

Route::group(['middleware' => 'brokerUser'], function (){
    Route::get('/broker',[BrokerController::class, 'index'])->name('broker.index');
    Route::post('/broker/edit/', [BrokerController::class, 'edit'])->name('broker.edit');
});

Route::group(['middleware' => 'sharedGroup'], function () {
    Route::get('/profile', [UserController::class, 'indexProfile'])->name('profile.index');
    Route::post('/profile/edit', [UserController::class, 'editUserByUser'])->name('profile.edit');
    Route::post('/profile/editPassword', [UserController::class, 'editPasswordByUser'])->name('password.edit');
    Route::post('/sharing-requests', [UserController::class, 'editPasswordByUser'])->name('sharing.request');       // TODO????

    Route::post('/sharing-requests/accept', [RequestsController::class, 'acceptShareRequest'])->name('sharing.request.accept');
    Route::get('/sharing-requests/deny/{id}', [RequestsController::class, 'denyShareRequest'])->name('sharing.request.deny');
});
