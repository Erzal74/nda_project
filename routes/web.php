<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'status'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/nda/create', [AdminController::class, 'showCreateForm'])->name('admin.nda.create');
        Route::post('/admin/nda', [AdminController::class, 'createNda'])->name('admin.nda.store');
        Route::get('/admin/nda/{nda}/edit', [AdminController::class, 'showEditForm'])->name('admin.nda.edit');
        Route::put('/admin/nda/{nda}', [AdminController::class, 'updateNda'])->name('admin.nda.update');
        Route::get('/admin/nda/{nda}/detail', [AdminController::class, 'showDetail'])->name('admin.nda.detail');
        Route::delete('/admin/nda/{nda}', [AdminController::class, 'deleteNda'])->name('admin.nda.delete');
        Route::put('/admin/user/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.user.approve');
        Route::put('/admin/user/{user}/reject', [AdminController::class, 'rejectUser'])->name('admin.user.reject');
        Route::put('/admin/user/{user}/disable', [AdminController::class, 'disableUser'])->name('admin.user.disable');
        Route::put('/admin/user/{user}/enable', [AdminController::class, 'enableUser'])->name('admin.user.enable');
        Route::delete('/admin/user/{user}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
        Route::delete('/admin/users/bulk-delete', [AdminController::class, 'bulkDeleteUsers'])->name('admin.user.bulk-delete');
        Route::delete('/admin/ndas/bulk-delete', [AdminController::class, 'bulkDeleteNdas'])->name('admin.nda.bulk-delete');
    });

    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/user/nda/{nda}/detail', [UserController::class, 'showDetail'])->name('user.nda.detail');
        Route::get('/user/download-all-files', [UserController::class, 'downloadAllFiles'])->name('user.download.all');
        Route::get('/user/export-to-excel', [UserController::class, 'exportToExcel'])->name('user.export.excel');
        Route::get('/user/print-report', [UserController::class, 'printReport'])->name('user.print.report');
    });
});

Route::get('/file/preview/{token}', [FileController::class, 'preview'])->name('file.preview');
Route::get('/file/download/{token}', [FileController::class, 'download'])->name('file.download');

Route::get('/', function () {
    return redirect()->route('login');
});
