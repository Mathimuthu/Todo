<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/task', function () {
        return view('task.index');
    })->name('task.index');
    
    Route::get('/task/create', function () {
        return view('task.create');
    })->name('task.create');
    
    Route::get('/task/{task}/edit', function ($taskId) {
        return view('task.edit', ['taskId' => $taskId]);
    })->name('task.edit');
});


require __DIR__.'/auth.php';
