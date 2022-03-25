<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\PositionContract;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApplicationDateController;
use App\Http\Controllers\Api\ApplicationStatusController;
use App\Http\Controllers\Api\CompletionController;
use App\Http\Controllers\Api\CompletionDateController;
use App\Http\Controllers\Api\CompletionStatusController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InvoiceDateController;
use App\Http\Controllers\Api\InvoiceStatusController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\RoleController;
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
    Route::post('auth',[UserController::class,'auth'])->name('user.auth');
    Route::post('create',[UserController::class,'create'])->name('user.create');
    Route::post('update/{id}',[UserController::class,'update'])->name('user.update');
    Route::post('password/{id}',[UserController::class,'password'])->name('user.password');
    Route::get('getByToken/{token}',[UserController::class,'getByToken'])->name('user.getByToken');
});

Route::prefix('application')->group(function() {
    Route::post('create',[ApplicationController::class,'create'])->name('application.create');
    Route::any('update/{id}',[ApplicationController::class,'update'])->name('application.update');
    Route::get('getById/{id}',[ApplicationController::class,'getById'])->name('application.getById');
    Route::get('getByRid/{rid}',[ApplicationController::class,'getByRid'])->name('application.getByRid');
});

Route::prefix('invoice')->group(function() {
    Route::post('create',[InvoiceController::class,'create'])->name('invoice.create');
    Route::any('update/{id}',[InvoiceController::class,'update'])->name('invoice.update');
    Route::get('getById/{id}',[InvoiceController::class,'getById'])->name('invoice.getById');
    Route::get('getByRid/{rid}',[InvoiceController::class,'getByRid'])->name('invoice.getByRid');
});

Route::prefix('completion')->group(function() {
    Route::post('create',[CompletionController::class,'create'])->name('completion.create');
    Route::any('update/{id}',[CompletionController::class,'update'])->name('completion.update');
    Route::get('getById/{id}',[CompletionController::class,'getById'])->name('completion.getById');
    Route::get('getByRid/{rid}',[CompletionController::class,'getByRid'])->name('completion.getByRid');
});

Route::prefix('completionDate')->group(function() {
    Route::post('pagination',[CompletionDateController::class,'pagination'])->name('completionDate.pagination');
    Route::post('list',[CompletionDateController::class,'list'])->name('completionDate.list');
    Route::post('update/{id}',[CompletionDateController::class,'update'])->name('completionDate.update');
    Route::get('getByRid/{rid}',[CompletionDateController::class,'getByRid'])->name('completionDate.getByRid');
    Route::get('getById/{id}',[CompletionDateController::class,'getById'])->name('completionDate.getById');
});

Route::prefix(MainContract::COMPLETION_STATUS)->group(function() {
    Route::get('list',[CompletionStatusController::class,'list'])->name('completionStatus.list');
});

Route::prefix('applicationDate')->group(function() {
    Route::post('pagination',[ApplicationDateController::class,'pagination'])->name('applicationDate.pagination');
    Route::post('list',[ApplicationDateController::class,'list'])->name('applicationDate.list');
    Route::post('update/{id}',[ApplicationDateController::class,'update'])->name('completionDate.update');
    Route::get('getByRid/{rid}',[ApplicationDateController::class,'getByRid'])->name('completionDate.getByRid');
    Route::get('getById/{id}',[ApplicationDateController::class,'getById'])->name('completionDate.getById');
});

Route::prefix(MainContract::APPLICATION_STATUS)->group(function() {
    Route::get('list',[ApplicationStatusController::class,'list'])->name('applicationStatus.list');
});

Route::prefix('invoiceDate')->group(function() {
    Route::post('pagination',[InvoiceDateController::class,'pagination'])->name('invoiceDate.pagination');
    Route::post('list',[InvoiceDateController::class,'list'])->name('invoiceDate.list');
    Route::post('update/{id}',[InvoiceDateController::class,'update'])->name('invoiceDate.update');
    Route::get('getByRid/{rid}',[InvoiceDateController::class,'getByRid'])->name('invoiceDate.getByRid');
    Route::get('getById/{id}',[InvoiceDateController::class,'getById'])->name('invoiceDate.getById');
});

Route::prefix(MainContract::INVOICE_STATUS)->group(function() {
    Route::get('list',[InvoiceStatusController::class,'list'])->name('invoiceStatus.list');
});

Route::prefix(PositionContract::TABLE)->group(function() {
    Route::get(MainContract::LIST,[PositionController::class,MainContract::LIST])->name(PositionContract::TABLE.'.'.MainContract::LIST);
});

Route::prefix('role')->group(function() {
    Route::get('list',[RoleController::class,'list'])->name('role.list');
});
