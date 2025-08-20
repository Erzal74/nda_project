<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {  // Hilangkan 'status' dan 'role'
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/nda/create', [AdminController::class, 'showCreateForm'])->name('admin.nda.create');
    Route::post('/admin/nda', [AdminController::class, 'createNda'])->name('admin.nda.store');
    Route::get('/admin/nda/{nda}/edit', [AdminController::class, 'showEditForm'])->name('admin.nda.edit');
    Route::put('/admin/nda/{nda}', [AdminController::class, 'updateNda'])->name('admin.nda.update');
    Route::get('/admin/nda/{nda}/detail', [AdminController::class, 'showDetail'])->name('admin.nda.detail');
    Route::delete('/admin/nda/{nda}', [AdminController::class, 'deleteNda'])->name('admin.nda.delete');
    Route::delete('/admin/ndas/bulk-delete', [AdminController::class, 'bulkDeleteNdas'])->name('admin.nda.bulk-delete');

    Route::get('/admin/nda/{nda}/download-file/{file}', [AdminController::class, 'downloadFile'])->name('admin.nda.download-file');
});

Route::get('/file/preview/{token}', [FileController::class, 'preview'])->name('file.preview');
Route::get('/file/download/{token}', [FileController::class, 'download'])->name('file.download');

Route::get('/', function () {
    return redirect()->route('login');
});
