<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    
    Route::prefix('auth')->group(function () {
        Route::get('unauthorized', [AuthController::class, 'unauthorized'])->name('api.auth.unauthorized');
    });

    Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

        /** tools **/
        Route::prefix('user')->group(function () {
            Route::get('limit/{qtd}', [UserController::class, 'listLimit'])->name('api.admin.user.listLimit');
            Route::get('', [UserController::class, 'index'])->name('api.admin.user.index');
            Route::post('', [UserController::class, 'store'])->name('api.admin.user.store');
            Route::get('{id}', [UserController::class, 'show'])->name('api.admin.user.show');
            Route::put('{id}', [UserController::class, 'update'])->name('api.admin.user.update');
            Route::delete('{id}', [UserController::class, 'destroy'])->name('api.admin.user.destroy');
        });
    });
});
