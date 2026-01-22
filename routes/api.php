<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuctionApiController;

Route::middleware('api')->group(function () {
    Route::get('/auction/{id}/live', [AuctionApiController::class, 'live']);
});
