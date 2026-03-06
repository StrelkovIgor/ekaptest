<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1;

Route::prefix('v1')->group(function () {

    Route::get('/products', v1\ProductController::class);

    Route::prefix('orders')
        ->controller(v1\OrderController::class)
        ->group(function(){
            Route::get('/', 'index');
            Route::get('/{order}', 'show');
            Route::post('/', 'store')->middleware('throttle:10,1');
            Route::patch('/{order}/status', 'updateStatus');
        });

});
