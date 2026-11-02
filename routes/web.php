<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicWeb\HomeController;
use App\Http\Controllers\PublicWeb\ServicesController;
use App\Http\Controllers\PublicWeb\LabShowcaseController;
use App\Http\Controllers\PublicWeb\VerifyCoaController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/services', [ServicesController::class, 'index']);
Route::get('/laboratory', [LabShowcaseController::class, 'index']);
Route::get('/verify-certificate', [VerifyCoaController::class, 'index']);
