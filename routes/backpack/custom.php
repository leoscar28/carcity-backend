<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('completion-status', 'CompletionStatusCrudController');
    Route::crud('application-status', 'ApplicationStatusCrudController');
    Route::crud('invoice-status', 'InvoiceStatusCrudController');
    Route::crud('position', 'PositionCrudController');
    Route::crud('user-bin', 'UserBinCrudController');
    Route::crud('tier', 'TierCrudController');
    Route::crud('room-type', 'RoomTypeCrudController');
    Route::crud('room', 'RoomCrudController');
    Route::crud('slider', 'SliderCrudController');
    Route::crud('slider-detail', 'SliderDetailCrudController');
    Route::crud('about', 'AboutCrudController');
    Route::crud('about-option', 'AboutOptionCrudController');
    Route::crud('infrastructure', 'InfrastructureCrudController');
    Route::crud('infrastructure-option', 'InfrastructureOptionCrudController');
    Route::crud('vehicle-maintenance', 'VehicleMaintenanceCrudController');
    Route::crud('contact', 'ContactCrudController');
    Route::crud('terms-of-use', 'TermsOfUseCrudController');
}); // this should be the absolute last line of this file