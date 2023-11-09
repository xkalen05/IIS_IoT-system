<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\Systems;
use App\Http\Controllers\Admin;

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
Route::get('/unregistred', function (){
    return view('unregistred');
})->name('systems');

/* Authentication */
Route::get('/', [AuthManager::class, 'login'])->name('login');
Route::post('/', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');


Route::get('/systems', [Systems::class, 'systems'])->name('systems');
Route::get('/admin', [Admin::class, 'admin'])->name('admin');
Route::get('/admin/{user}',[Admin::class, 'editUser']);
Route::post('/edit-user',[Admin::class, 'editUserPost'])->name('edit-user.post');
