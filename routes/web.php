<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FaskesController;
use App\Http\Controllers\TahapanController;
use App\Http\Controllers\SubMasterController;
use App\Http\Controllers\SubSectionController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // Added UserController import
use App\Http\Controllers\AdminFaskesController; // Added AdminFaskesController import
use App\Http\Controllers\AdminMasterController; // Added AdminMasterController import
use App\Http\Controllers\AdminSubMasterController; // Added AdminSubMasterController import
use App\Http\Controllers\AdminSubSectionController; // Added AdminSubSectionController import
use App\Models\User; // Import User model

// ==================== ROUTE AUTHENTICATION ====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // <- UBAH INI
Route::post('/login', [AuthController::class, 'login']); // <- UBAH INI
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // <- UBAH INI

Route::get('/create-admin-megan', function () {
    if (User::where('email', 'megan@trustmedis.com')->exists()) {
        return 'User megan@trustmedis.com already exists!';
    }

    User::create([
        'name' => 'megan',
        'email' => 'megan@trustmedis.com',
        'password' => 'megan1234', // Will be hashed by model cast
        'role' => 'admin',
        'jabatan' => 'magang',
    ]);

    return 'User megan@trustmedis.com created successfully! You can now login.';
});

// ==================== DEFAULT ROUTE ====================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==================== PROTECTED ROUTES ====================
Route::middleware(['auth'])->group(function () {
    
    // ==================== ROUTE ADMIN ====================
    Route::get('/admin/dashboard', function () {
        return view('admin.admindash');
    })->name('admin.dashboard');

    Route::resource('users', UserController::class);
    
    Route::resource('admin/faskes', AdminFaskesController::class, [
        'names' => 'admin.faskes'
    ]);

    Route::resource('admin/master', AdminMasterController::class, [
        'names' => 'admin.master'
    ]);

    Route::resource('admin/submaster', AdminSubMasterController::class, [
        'names' => 'admin.submaster'
    ]);

    // ==================== ROUTE ADMIN SUBSECTION ====================
    Route::resource('admin/subsection', AdminSubSectionController::class, [
        'names' => 'admin.subsection'
    ]);

    // ==================== ROUTE DASHBOARD ====================
    Route::get('/dashboard', [FaskesController::class, 'index'])->name('dashboard');

    // ==================== ROUTE FASKES ====================
    Route::resource('faskes', FaskesController::class);

    // ==================== ROUTE TAHAPAN ====================
    Route::prefix('faskes/{faskes_id}')->group(function () {
        Route::get('/tahapan/create', [TahapanController::class, 'create'])->name('tahapan.create');
        Route::post('/tahapan/store', [TahapanController::class, 'store'])->name('tahapan.store');
    });

    // EDIT & UPDATE TAHAPAN
    Route::get('/tahapan/{id}/edit', [TahapanController::class, 'edit'])->name('tahapan.edit');
    Route::put('/tahapan/{id}', [TahapanController::class, 'update'])->name('tahapan.update');
    Route::delete('/tahapan/{id}', [TahapanController::class, 'destroy'])->name('tahapan.destroy');

    // ==================== ROUTE SUBMASTER ====================
    Route::post('/submaster/store', [SubMasterController::class, 'store'])->name('submaster.store');
    Route::get('/submaster/{id}/edit', [SubMasterController::class, 'edit'])->name('submaster.edit');
    Route::put('/submaster/{id}', [SubMasterController::class, 'update'])->name('submaster.update');
    Route::delete('/submaster/{id}', [SubMasterController::class, 'destroy'])->name('submaster.destroy');

    // ==================== ROUTE SUBMASTER STATUS ====================
    Route::patch('/submaster/{id}/complete', [SubMasterController::class, 'markAsCompleted'])->name('submaster.complete');
    Route::patch('/submaster/{id}/pending', [SubMasterController::class, 'markAsPending'])->name('submaster.pending');

    // ==================== ROUTE SUBSECTION ====================
    Route::post('/subsection/store', [SubSectionController::class, 'store'])->name('subsection.store');
    Route::get('/subsection/{id}/edit', [SubSectionController::class, 'edit'])->name('subsection.edit');
    Route::put('/subsection/{id}', [SubSectionController::class, 'update'])->name('subsection.update');
    Route::delete('/subsection/{id}', [SubSectionController::class, 'destroy'])->name('subsection.destroy');

    // ==================== ROUTE SUBSECTION STATUS ====================
    Route::patch('/subsection/{id}/complete', [SubSectionController::class, 'markAsCompleted'])->name('subsection.complete');
    Route::patch('/subsection/{id}/pending', [SubSectionController::class, 'markAsPending'])->name('subsection.pending');

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

    // ==================== ROUTE CALENDAR ====================
    Route::get('/kalender', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/api/kalender/events', [CalendarController::class, 'apiEvents'])->name('calendar.events');
});
