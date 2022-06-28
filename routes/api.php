<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\PositionContract;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AboutOptionController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApplicationDateController;
use App\Http\Controllers\Api\ApplicationSignatureController;
use App\Http\Controllers\Api\ApplicationStatusController;
use App\Http\Controllers\Api\CompletionController;
use App\Http\Controllers\Api\CompletionDateController;
use App\Http\Controllers\Api\CompletionSignatureController;
use App\Http\Controllers\Api\CompletionStatusController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InvoiceDateController;
use App\Http\Controllers\Api\InvoiceStatusController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\NotificationTenantController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\SliderDetailController;
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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization,X-localization,X-No-Cache');

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('dasdasd',function() {
    return phpinfo();
});

Route::prefix('user')->group(function() {
    Route::post('list',[UserController::class,'list'])->name('list');
    Route::post('auth',[UserController::class,'auth'])->name('auth');
    Route::post('create',[UserController::class,'create'])->name('create');
    Route::post('update/{id}',[UserController::class,'update'])->name('update');
    Route::post('password/{id}',[UserController::class,'password'])->name('password');
    Route::post('codeCheck',[UserController::class,'codeCheck'])->name('codeCheck');
    Route::get('getByToken/{token}',[UserController::class,'getByToken'])->name('getByToken');
    Route::get('restore/{phone}',[UserController::class,'restore'])->name('restore');
});

Route::prefix('completionSignature')->group(function() {
    Route::get('multipleStart/{rid}/{userId}',[CompletionSignatureController::class,'multipleStart'])->name('completionSignature.multipleStart');
    Route::get('start/{id}/{userId}',[CompletionSignatureController::class,'start'])->name('completionSignature.start');
    Route::post('multipleCreate',[CompletionSignatureController::class,'multipleCreate'])->name('completionSignature.multipleCreate');
    Route::post('create',[CompletionSignatureController::class,'create'])->name('completionSignature.create');
    Route::post('update/{id}',[CompletionSignatureController::class,'update'])->name('completionSignature.update');
    Route::get('getByCompletionId/{id}',[CompletionSignatureController::class,'getByCompletionId'])->name('completionSignature.getByApplicationId');
});

Route::prefix('applicationSignature')->group(function() {
    Route::get('multipleStart/{rid}/{userId}',[ApplicationSignatureController::class,'multipleStart'])->name('applicationSignature.multipleStart');
    Route::get('start/{id}/{userId}',[ApplicationSignatureController::class,'start'])->name('applicationSignature.start');
    Route::post('multipleCreate',[ApplicationSignatureController::class,'multipleCreate'])->name('applicationSignature.multipleCreate');
    Route::post('create',[ApplicationSignatureController::class,'create'])->name('applicationSignature.create');
    Route::post('update/{id}',[ApplicationSignatureController::class,'update'])->name('applicationSignature.update');
    Route::get('getByApplicationId/{id}',[ApplicationSignatureController::class,'getByApplicationId'])->name('applicationSignature.getByApplicationId');
});

Route::prefix('application')->group(function() {
    Route::get('downloadAll/{rid}',[ApplicationController::class,'downloadAll'])->name('application.downloadAll');
    Route::post('downloadByIds',[ApplicationController::class,'downloadByIds'])->name('application.downloadByIds');
    Route::post('download',[ApplicationController::class,'download'])->name('application.download');
    Route::post('create',[ApplicationController::class,'create'])->name('application.create');
    Route::post('pagination',[ApplicationController::class,'pagination'])->name('application.pagination');
    Route::post('all',[ApplicationController::class,'all'])->name('application.all');
    Route::post('get',[ApplicationController::class,'get'])->name('application.get');
    Route::any('update/{id}',[ApplicationController::class,'update'])->name('application.update');
    Route::get('getById/{id}',[ApplicationController::class,'getById'])->name('application.getById');
    Route::get('getByRid/{rid}',[ApplicationController::class,'getByRid'])->name('application.getByRid');
    Route::get('delete/{rid}/{id}',[ApplicationController::class,'delete'])->name('application.delete');
});

Route::prefix('invoice')->group(function() {
    Route::get('downloadAll/{rid}',[InvoiceController::class,'downloadAll'])->name('invoice.downloadAll');
    Route::post('downloadByIds',[InvoiceController::class,'downloadByIds'])->name('invoice.downloadByIds');
    Route::post('download',[InvoiceController::class,'download'])->name('invoice.download');
    Route::post('create',[InvoiceController::class,'create'])->name('invoice.create');
    Route::post('pagination',[InvoiceController::class,'pagination'])->name('invoice.pagination');
    Route::post('all',[InvoiceController::class,'all'])->name('invoice.all');
    Route::any('update/{id}',[InvoiceController::class,'update'])->name('invoice.update');
    Route::get('getById/{id}',[InvoiceController::class,'getById'])->name('invoice.getById');
    Route::get('getById/{id}',[InvoiceController::class,'getById'])->name('invoice.getById');
    Route::get('getByRid/{rid}',[InvoiceController::class,'getByRid'])->name('invoice.getByRid');
    Route::get('delete/{rid}/{id}',[InvoiceController::class,'delete'])->name('invoice.delete');
});

Route::prefix('slider')->group(function() {
    Route::get('get',[SliderController::class,'get'])->name('slider.get');
});

Route::prefix('sliderDetail')->group(function() {
    Route::get('get',[SliderDetailController::class,'get'])->name('sliderDetail.get');
});

Route::prefix('about')->group(function() {
    Route::get('get',[AboutController::class,'get'])->name('about.get');
});

Route::prefix('aboutOption')->group(function() {
    Route::get('get',[AboutOptionController::class,'get'])->name('aboutOption.get');
});

Route::prefix('room')->group(function() {
    Route::get('getByUserId/{userId}',[RoomController::class,'getByUserId'])->name('room.getByUserId');
});

Route::prefix('completion')->group(function() {
    Route::get('downloadAll/{rid}',[CompletionController::class,'downloadAll'])->name('completion.downloadAll');
    Route::post('downloadByIds',[CompletionController::class,'downloadByIds'])->name('completion.downloadByIds');
    Route::post('download',[CompletionController::class,'download'])->name('completion.download');
    Route::post('create',[CompletionController::class,'create'])->name('completion.create');
    Route::post('pagination',[CompletionController::class,'pagination'])->name('completion.pagination');
    Route::post('all',[CompletionController::class,'all'])->name('completion.all');
    Route::any('update/{id}',[CompletionController::class,'update'])->name('completion.update');
    Route::get('getById/{id}',[CompletionController::class,'getById'])->name('completion.getById');
    Route::get('getByRid/{rid}',[CompletionController::class,'getByRid'])->name('completion.getByRid');
    Route::get('delete/{rid}/{id}',[CompletionController::class,'delete'])->name('completion.delete');
});

Route::prefix('completionDate')->group(function() {
    Route::post('pagination',[CompletionDateController::class,'pagination'])->name('completionDate.pagination');
    Route::post('list',[CompletionDateController::class,'list'])->name('completionDate.list');
    Route::post('get',[CompletionDateController::class,'get'])->name('completionDate.get');
    Route::post('update/{id}',[CompletionDateController::class,'update'])->name('completionDate.update');
    Route::get('getByRid/{rid}',[CompletionDateController::class,'getByRid'])->name('completionDate.getByRid');
    Route::get('getById/{id}',[CompletionDateController::class,'getById'])->name('completionDate.getById');
    Route::get('delete/{rid}',[CompletionDateController::class,'delete'])->name('completionDate.delete');
});

Route::prefix(MainContract::COMPLETION_STATUS)->group(function() {
    Route::get('list',[CompletionStatusController::class,'list'])->name('completionStatus.list');
});

Route::prefix('applicationDate')->group(function() {
    Route::post('pagination',[ApplicationDateController::class,'pagination'])->name('applicationDate.pagination');
    Route::post('list',[ApplicationDateController::class,'list'])->name('applicationDate.list');
    Route::post('get',[ApplicationDateController::class,'get'])->name('applicationDate.get');
    Route::post('update/{id}',[ApplicationDateController::class,'update'])->name('applicationDate.update');
    Route::get('getByRid/{rid}',[ApplicationDateController::class,'getByRid'])->name('applicationDate.getByRid');
    Route::get('getById/{id}',[ApplicationDateController::class,'getById'])->name('applicationDate.getById');
    Route::get('delete/{rid}',[ApplicationDateController::class,'delete'])->name('applicationDate.delete');
});

Route::prefix(MainContract::APPLICATION_STATUS)->group(function() {
    Route::get('list',[ApplicationStatusController::class,'list'])->name('applicationStatus.list');
});

Route::prefix('invoiceDate')->group(function() {
    Route::post('pagination',[InvoiceDateController::class,'pagination'])->name('invoiceDate.pagination');
    Route::post('list',[InvoiceDateController::class,'list'])->name('invoiceDate.list');
    Route::post('get',[InvoiceDateController::class,'get'])->name('invoiceDate.get');
    Route::post('update/{id}',[InvoiceDateController::class,'update'])->name('invoiceDate.update');
    Route::get('getByRid/{rid}',[InvoiceDateController::class,'getByRid'])->name('invoiceDate.getByRid');
    Route::get('getById/{id}',[InvoiceDateController::class,'getById'])->name('invoiceDate.getById');
    Route::get('delete/{rid}',[InvoiceDateController::class,'delete'])->name('invoiceDate.delete');
});

Route::prefix('notification')->group(function() {
    Route::get('getByUserId/{userId}/{skip}',[NotificationController::class,'getByUserId'])->name('notification.getByUserId');
    Route::get('viewCount/{userId}',[NotificationController::class,'viewCount'])->name('notification.viewCount');
    Route::get('count/{userId}',[NotificationController::class,'count'])->name('notification.count');
    Route::post('get',[NotificationController::class,'get'])->name('notification.get');
    Route::post('setView',[NotificationController::class,'setView'])->name('notification.setView');
});

Route::prefix('notificationTenant')->group(function() {
    Route::get('getByUserId/{userId}/{skip}',[NotificationTenantController::class,'getByUserId'])->name('notificationTenant.getByUserId');
    Route::get('viewCount/{userId}',[NotificationTenantController::class,'viewCount'])->name('notificationTenant.viewCount');
    Route::get('count/{userId}',[NotificationTenantController::class,'count'])->name('notificationTenant.count');
    Route::post('get',[NotificationTenantController::class,'get'])->name('notificationTenant.get');
    Route::post('setView',[NotificationTenantController::class,'setView'])->name('notificationTenant.setView');
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
