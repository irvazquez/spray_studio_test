<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
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
 