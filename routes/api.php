<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function() {
    Route::post('create',[UserController::class,'create'])->name('user.create');
    Route::get('getByToken/{token}',[UserController::class,'getByToken'])->name('user.getByToken');
});

Route::prefix('application')->group(function() {
    Route::post('create',[ApplicationController::class,'create'])->name('application.create');
    Route::post('update/{id}',[ApplicationController::class,'update'])->name('application.update');
    Route::get('getById/{id}',[ApplicationController::class,'getById'])->name('application.getById');
});

Route::prefix('invoice')->group(function() {
    Route::post('create',[InvoiceController::class,'create'])->name('invoice.create');
    Route::post('update/{id}',[InvoiceController::class,'update'])->name('invoice.update');
    Route::get('getById/{id}',[InvoiceController::class,'getById'])->name('invoice.getById');
});

Route::prefix('completion')->group(function() {
    Route::post('create',[InvoiceController::class,'create'])->name('completion.create');
    Route::post('update/{id}',[InvoiceController::class,'update'])->name('completion.update');
    Route::get('getById/{id}',[InvoiceController::class,'getById'])->name('completion.getById');
});
