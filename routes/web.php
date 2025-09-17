<?php

use App\Http\Controllers\TaskController;

Route::get('/', fn () => redirect()->route('tasks.index'));

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::resource('tasks', TaskController::class)->middleware('auth');
    Route::get('/dashboard', function () {
    return redirect('/tasks'); // arahkan ke halaman yang sudah ada
})->name('dashboard');
});

require __DIR__.'/auth.php'; 

