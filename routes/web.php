<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaskesController;
use App\Http\Controllers\SubMasterController;
use App\Http\Controllers\SubSectionController;
// use App\Http\Controllers\MasterController;
// use App\Http\Controllers\SectionController;

// Dashboard → tampilkan daftar faskes
Route::get('/', [FaskesController::class, 'index'])->name('dashboard');

// CRUD Faskes
Route::resource('faskes', FaskesController::class);
Route::get('/faskes/{id}/detail', [FaskesController::class, 'detail'])->name('faskes.detail');
use App\Http\Controllers\TahapanController;

// Form tambah tahapan
Route::get('/faskes/{id}/tahapan/create', [TahapanController::class, 'create'])
    ->name('tahapan.create');

// Simpan tahapan
Route::post('/faskes/{id}/tahapan/store', [TahapanController::class, 'store'])
    ->name('tahapan.store');

// SubMaster Routes - SIMPAN SUB MASTER
Route::post('/submaster/store', [SubMasterController::class, 'store'])->name('submaster.store');

// SubSection Routes
Route::post('/subsection/store', [SubSectionController::class, 'store'])->name('subsection.store');