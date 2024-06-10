<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\PengajuanController;
use App\Http\Controllers\API\ManagerPengajuanController;
use App\Http\Controllers\API\FinancePengajuanController;

Route::post('register', [RegisterController::class, 'register']);
Route::post('forgot-password', [ForgotPasswordController::class, 'forgot']);
Route::post('login', [LoginController::class, 'login']);
Route::post('reset-password', [ForgotPasswordController::class, 'reset']);
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth', 'role:officer']], function () {
    Route::get('pengajuans', [PengajuanController::class, 'index']);
    Route::post('pengajuans', [PengajuanController::class, 'store']);
    Route::post('pengajuans/{id}/update', [PengajuanController::class, 'update']);
    Route::post('pengajuans/{id}/delete', [PengajuanController::class, 'destroy']);
});

Route::group(['middleware' => ['auth', 'role:manager']], function () {
    Route::get('manager/pengajuans', [ManagerPengajuanController::class, 'index']);
    Route::post('manager/pengajuans/{id}/approve', [ManagerPengajuanController::class, 'approvePengajuan']);
    Route::post('manager/pengajuans/{id}/reject', [ManagerPengajuanController::class, 'rejectPengajuan']);
});


Route::group(['middleware' => ['auth', 'role:finance']], function () {
    Route::get('finance/pengajuans', [FinancePengajuanController::class, 'index']);
    Route::post('finance/pengajuans/{id}/approve', [FinancePengajuanController::class, 'approvePengajuan']);
    Route::post('finance/pengajuans/{id}/reject', [FinancePengajuanController::class, 'rejectPengajuan']);
});