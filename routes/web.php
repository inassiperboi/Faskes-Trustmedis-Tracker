<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FaskesController;
use App\Http\Controllers\TahapanController;
use App\Http\Controllers\SubMasterController;
use App\Http\Controllers\SubSectionController;

// ==================== ROUTE DASHBOARD ====================
Route::get('/', [FaskesController::class, 'index'])->name('dashboard');

// ==================== ROUTE FASKES ====================
Route::resource('faskes', FaskesController::class);

// ==================== ROUTE TAHAPAN ====================
Route::prefix('faskes/{faskes_id}')->group(function () {
    Route::get('/tahapan/create', [TahapanController::class, 'create'])->name('tahapan.create');
    Route::post('/tahapan/store', [TahapanController::class, 'store'])->name('tahapan.store');
});

// EDIT & UPDATE TAHAPAN
Route::get('/tahapan/{id}/edit', [TahapanController::class, 'edit'])->name('tahapan.edit');
Route::put('/tahapan/{id}/update', [TahapanController::class, 'update'])->name('tahapan.update');
Route::delete('/tahapan/{id}/destroy', [TahapanController::class, 'destroy'])->name('tahapan.destroy'); // INI YANG DITAMBAHKAN

// ==================== ROUTE SUBMASTER ====================
Route::post('/submaster/store', [SubMasterController::class, 'store'])->name('submaster.store');
Route::get('/submaster/{id}/edit', [SubMasterController::class, 'edit'])->name('submaster.edit');
Route::put('/submaster/{id}/update', [SubMasterController::class, 'update'])->name('submaster.update');
Route::delete('/submaster/{id}/destroy', [SubMasterController::class, 'destroy'])->name('submaster.destroy');

// ==================== ROUTE SUBSECTION ====================
Route::post('/subsection/store', [SubSectionController::class, 'store'])->name('subsection.store');
Route::get('/subsection/{id}/edit', [SubSectionController::class, 'edit'])->name('subsection.edit');
Route::put('/subsection/{id}/update', [SubSectionController::class, 'update'])->name('subsection.update');
Route::delete('/subsection/{id}/destroy', [SubSectionController::class, 'destroy'])->name('subsection.destroy');

// ==================== ROUTE FILE HANDLING ====================
Route::get('/download/{type}/{id}', function ($type, $id) {
    $model = match($type) {
        'tahapan' => \App\Models\Master::findOrFail($id),
        'submaster' => \App\Models\SubMaster::findOrFail($id),
        'subsection' => \App\Models\SubSection::findOrFail($id),
        default => abort(404, 'Tipe file tidak valid')
    };
    
    if (!$model->file_path || !Storage::disk('public')->exists($model->file_path)) {
        return back()->with('error', 'File tidak ditemukan.');
    }
    
    return Storage::disk('public')->download($model->file_path, $model->file_original_name);
})->name('download.file');

Route::get('/preview/{type}/{id}', function ($type, $id) {
    $model = match($type) {
        'tahapan' => \App\Models\Master::findOrFail($id),
        'submaster' => \App\Models\SubMaster::findOrFail($id),
        'subsection' => \App\Models\SubSection::findOrFail($id),
        default => abort(404, 'Tipe file tidak valid')
    };
    
    if (!$model->file_path || !Storage::disk('public')->exists($model->file_path)) {
        abort(404, 'File tidak ditemukan');
    }
    
    return response()->file(storage_path('app/public/' . $model->file_path));
})->name('preview.file');