<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::apiResource("task",TaskController::class);
Route::put('/task/{task}', [TaskController::class, 'update']); 
Route::delete('/task/{task}', [TaskController::class, 'destroy']);
