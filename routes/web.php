<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

// Routes auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PERBAIKAN: Group admin dengan middleware dan prefix
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pegawai/create', [AdminController::class, 'showCreatePegawaiForm'])->name('pegawai.create');
    Route::post('/pegawai', [AdminController::class, 'createPegawai'])->name('pegawai.store');
    Route::get('/pegawai/{user}/edit', [AdminController::class, 'showEditPegawaiForm'])->name('pegawai.edit');
    Route::put('/pegawai/{user}', [AdminController::class, 'updatePegawai'])->name('pegawai.update'); // PERBAIKAN: Gunakan PUT untuk update
    Route::delete('/pegawai/{user}', [AdminController::class, 'deletePegawai'])->name('pegawai.delete'); // PERBAIKAN: Gunakan DELETE untuk hapus
    Route::get('/pegawai/{user}/detail', [AdminController::class, 'showDetailPegawai'])->name('pegawai.detail'); // TAMBAH: Route untuk detail pegawai
});

// PERBAIKAN: Group pegawai dengan middleware dan prefix
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');
    Route::get('/nda/create', [PegawaiController::class, 'showCreateForm'])->name('nda.create');
    Route::post('/nda', [PegawaiController::class, 'createNda'])->name('nda.store');
    Route::get('/nda/{nda}/edit', [PegawaiController::class, 'showEditForm'])->name('nda.edit');
    Route::put('/nda/{nda}', [PegawaiController::class, 'updateNda'])->name('nda.update'); // PERBAIKAN: Gunakan PUT
    Route::get('/nda/{nda}/detail', [PegawaiController::class, 'showDetail'])->name('nda.detail');
    Route::delete('/nda/{nda}', [PegawaiController::class, 'deleteNda'])->name('nda.delete'); // PERBAIKAN: Gunakan DELETE
    Route::delete('/ndas/bulk-delete', [PegawaiController::class, 'bulkDeleteNdas'])->name('nda.bulk-delete');
    Route::get('/nda/{nda}/download-file/{file}', [PegawaiController::class, 'downloadFile'])->name('nda.download-file');
});

// Routes lain
Route::get('/file/preview/{token}', [FileController::class, 'preview'])->name('file.preview');
Route::get('/file/download/{token}', [FileController::class, 'download'])->name('file.download');

Route::get('/', function () {
    return redirect()->route('login');
});
