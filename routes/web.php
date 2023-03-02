<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as ProjectController;
use App\Http\Controllers\Guest\ProjectController as GuestProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[ GuestProjectController::class, 'index'])->name('guest.index'); 

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            // Qui posso aggiungere altre rotte che io voglio siano protette da login e collocate in admin
            Route::patch('/{project}/toggle', [ProjectController::class, 'enableToggle'])->name('projects.toggle')->withTrashed();
            Route::get('/trashed', [ProjectController::class, 'trashed'])->name('projects.trashed');
            Route::post('/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
            Route::delete('/{project}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.force-delete');
            Route::post('/restore-all', [ProjectController::class, 'restoreAll'])->name('projects.restore-all');
            Route::resource('/projects', ProjectController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// Questo require serve ad aggiungere tutte le rotte che ci servono sulla autenticazione
