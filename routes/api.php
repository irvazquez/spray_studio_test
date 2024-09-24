<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PackageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function() {
    Route::post('/', 'create')->name('create');
});

Route::controller(ActivityController::class)->prefix('activities')->name('activities.')->group(
    function() {
        Route::get('/', 'findAll')->name('all');
        Route::post('/', 'create')->name('create');
    }
);

Route::controller(PackageController::class)->prefix('packages')->name('packages.')->group(
    function() {
        Route::get('/{activity_id}', 'findAllForActivity')->name('activity');
        Route::post('/{activity_id}', 'create')->name('create');
    }
);

Route::controller(PackageController::class)->prefix('packages')->name('packages.')->group(
    function() {
        Route::get('/{activity_id}', 'findAllForActivity')->name('activity');
        Route::post('/{activity_id}', 'create')->name('create');
    }
);
