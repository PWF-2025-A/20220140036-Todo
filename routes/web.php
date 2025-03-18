<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController; // Tambahkan ini
use App\Http\Controllers\UserController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk TodoController
Route::middleware('auth')->group(function () {
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    Route::get('/todo/{id}', [TodoController::class, 'show'])->name('todo.show');
    Route::get('/todo/{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');

    // Route untuk ProfileController (sudah benar)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');

});

// Auth routes (sudah benar)
require __DIR__.'/auth.php';
