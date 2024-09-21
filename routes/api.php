<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function() {
    Route::post('/', 'create')->name('create');
});
