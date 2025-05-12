<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('categories', CategoryController::class); // pindah ke sini

    // Todo routes
    Route::resource('todo', TodoController::class)->except(['show']);
    // Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    // Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    // Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    // Route::get('/todo/{id}', [TodoController::class, 'show'])->name('todo.show');
    // Route::get('/todo/{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    // Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
    // Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');

    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
    Route::delete('/todo', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');


    


    
    Route::middleware(['auth', 'admin'])->group(function(){
        Route::resource('user', UserController::class)->except(['show']);
        Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
        Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');


    });

    //Kategori

    
});

require __DIR__.'/auth.php';