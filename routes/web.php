<?php

use App\Http\Controllers\Api\V0\UserController;
use App\Http\Controllers\Api\V0\PostController;
use App\Http\Controllers\Api\V0\CommentController;
use App\Http\Controllers\Api\V0\ReactionController;
use App\Http\Controllers\Api\V0\ReactionTypeController;
use App\Http\Controllers\Api\V0\FollowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=> 'api/v0', 'namespace' => 'App\Http\Controllers\Api\V0'], function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('reactions', ReactionController::class);
    Route::apiResource('reaction-types', ReactionTypeController::class);
    Route::apiResource('follows', FollowController::class);
});