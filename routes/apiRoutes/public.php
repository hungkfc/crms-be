<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'api'], function () {
    Route::group([], function () {
            Route::get('posts',[PostsController::class, 'index']);
            Route::post('posts',[PostsController::class, 'store']);
            Route::get('detail_posts',[PostsController::class, 'show']);
            Route::put('posts',[PostsController::class, 'update']);
            Route::delete('delete_posts',[PostsController::class, 'destroy']);
        });
});