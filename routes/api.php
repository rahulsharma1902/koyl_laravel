<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\DoctorRegisterController;
use App\Http\Controllers\DoctorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::any('login', [LoginController::class, 'login']);

Route::post('register-patient', [RegisterController::class, 'patientRegister']);



Route::post('register-doctor', [DoctorRegisterController::class, 'doctorRegister']);

Route::get('doctors', [DoctorController::class, 'index']);


// Route::middleware(['verify_api_token'])->group(function () {
    Route::post('complete-profile',[RegisterController::class, 'completeProfile']);
// });