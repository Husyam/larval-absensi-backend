<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// "id": 2,
//     "name": "User 1",
//     "email": "user@gmail.com",
//     "phone": "0891232132",
//     "position": "Staff",
//     "department": "IT",
//     "face_embedding": "aaaa",
//     "image_url": "IU6BHmZzHKFs1Gszoqljvt06h0tohxcFsJ16XCTY.png",
//     "email_verified_at": "2024-10-23T09:58:30.000000Z",
//     "two_factor_secret": null,
//     "two_factor_recovery_codes": null,
//     "two_factor_confirmed_at": null,
//     "created_at": "2024-10-23T09:58:30.000000Z",
//     "updated_at": "2024-10-23T13:15:18.000000Z"

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/company', [App\Http\Controllers\Api\CompanyController::class, 'show'])->middleware('auth:sanctum');

Route::post('checkin', [App\Http\Controllers\Api\AttendanceController::class, 'checkin'])->middleware('auth:sanctum');
Route::post('checkout', [App\Http\Controllers\Api\AttendanceController::class, 'checkout'])->middleware('auth:sanctum');
Route::get('is-checkin', [App\Http\Controllers\Api\AttendanceController::class, 'isCheckedin'])->middleware('auth:sanctum');

Route::post('update-profile', [App\Http\Controllers\Api\AuthController::class, 'updateProfile'])->middleware('auth:sanctum');

Route::apiResource('permission-absensi', App\Http\Controllers\Api\PermissionAbsenController::class)->middleware('auth:sanctum');

Route::apiResource('notes', App\Http\Controllers\Api\NoteController::class)->middleware('auth:sanctum');

//get getUser
Route::get('get-user', [App\Http\Controllers\Api\AuthController::class, 'getUser'])->middleware('auth:sanctum');
