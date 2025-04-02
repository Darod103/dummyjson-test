<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;

Route::middleware('api')->group(function () {
    Route::post('/import/{entity}', [ImportController::class, 'import']);
});
