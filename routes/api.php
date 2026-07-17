<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);
Route::apiResource('tasks', TaskController::class);
