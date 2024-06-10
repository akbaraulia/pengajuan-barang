<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['auth', 'role:officer']], function () {
    Route::resource('pengajuans', 'PengajuanController');
});

Route::group(['middleware' => ['auth', 'role:manager']], function () {
    Route::get('manager/pengajuans', 'ManagerPengajuanController@index');
    Route::post('manager/pengajuans/{id}/approve', 'ManagerPengajuanController@approve');
    Route::post('manager/pengajuans/{id}/reject', 'ManagerPengajuanController@reject');
});

Route::group(['middleware' => ['auth', 'role:finance']], function () {
    Route::get('finance/pengajuans', 'FinancePengajuanController@index');
    Route::post('finance/pengajuans/{id}/approve', 'FinancePengajuanController@approve');
    Route::post('finance/pengajuans/{id}/reject', 'FinancePengajuanController@reject');
    Route::post('finance/pengajuans/{id}/upload', 'FinancePengajuanController@upload');
});
