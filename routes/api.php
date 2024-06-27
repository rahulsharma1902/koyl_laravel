<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\DoctorRegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::any('login', [LoginController::class, 'login']);

Route::post('register-patient', [RegisterController::class, 'patientRegister']);

Route::any('logout', [LogoutController::class, 'logout']);


Route::post('register-doctor', [DoctorRegisterController::class, 'doctorRegister']);

Route::get('doctors', [DoctorController::class, 'index']);
Route::get('request-doctors', [DoctorController::class, 'requestDoctors']);

Route::post('request-approve',[DoctorController::class,'requestApprove']);
Route::post('remove-doctor',[DoctorController::class,'removeDoctorAccount']);

Route::get('doctor-detail/{id}', [DoctorController::class, 'doctorDetail']);
Route::post('update-doctor',[DoctorController::class, 'updateDoctor']);


// Route Api for Doctor Dashboard 
Route::get('patients', [PatientController::class, 'index']);
Route::get('patient-detail/{id}', [PatientController::class, 'patientDetail']);



// Route::middleware(['verify_api_token'])->group(function () {
    Route::post('complete-profile',[RegisterController::class, 'completeProfile']);
// });