<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionAbsenController;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;


Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Route::middleware(['auth', 'role:admin|Super Admin'])->group(function () {
//     Route::get('home', function () {
//         return view('pages.dashboard', ['type_menu' => 'home']);
//     })->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');

    Route::resource('users', UserController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('permissions-absensi', PermissionAbsenController::class);

    //permissions
    Route::resource('permissions', PermissionController::class);

    //roles
    Route::resource('roles', RoleController::class);
});
