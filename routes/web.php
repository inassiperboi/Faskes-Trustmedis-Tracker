<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaskesController;
use App\Http\Controllers\SubMasterController;
use App\Http\Controllers\SubSectionController;
use Illuminate\Support\Facades\Storage;
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

// Route untuk download file
Route::get('/download/{type}/{id}', function ($type, $id) {
    if ($type === 'tahapan') {
        $item = \App\Models\Master::findOrFail($id);
    } elseif ($type === 'submaster') {
        $item = \App\Models\SubMaster::findOrFail($id);
    } elseif ($type === 'subsection') {
        $item = \App\Models\SubSection::findOrFail($id);
    } else {
        abort(404);
    }
    
    if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
        return Storage::disk('public')->download($item->file_path, $item->file_original_name);
    }
    
    return back()->with('error', 'File tidak ditemukan.');
})->name('download.file');

// Route untuk preview file
Route::get('/preview/{type}/{id}', function ($type, $id) {
    if ($type === 'tahapan') {
        $item = \App\Models\Master::findOrFail($id);
    } elseif ($type === 'submaster') {
        $item = \App\Models\SubMaster::findOrFail($id);
    } elseif ($type === 'subsection') {
        $item = \App\Models\SubSection::findOrFail($id);
    } else {
        abort(404);
    }
    
    if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
        return response()->file(storage_path('app/public/' . $item->file_path));
    }
    
    abort(404);
})->name('preview.file');