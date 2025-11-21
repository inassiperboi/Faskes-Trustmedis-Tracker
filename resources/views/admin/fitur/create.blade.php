@extends('layouts.admin')

@section('header', 'Tambah Fitur')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Tambah Fitur</h2>
        <a href="{{ route('admin.fitur.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.fitur.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="no_assessment">No Assessment <span style="color: red;">*</span></label>
            <input type="text" name="no_assessment" id="no_assessment" class="form-control" value="{{ old('no_assessment') }}" required>
            @error('no_assessment')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="judul">Judul <span style="color: red;">*</span></label>
            <textarea name="judul" id="judul" rows="3" class="form-control" required>{{ old('judul') }}</textarea>
            @error('judul')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="target_uat">Target UAT <span style="color: red;">*</span></label>
            <input type="date" name="target_uat" id="target_uat" class="form-control" value="{{ old('target_uat') }}" required>
            @error('target_uat')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="target_due_date">Target Due Date <span style="color: red;">*</span></label>
            <input type="date" name="target_due_date" id="target_due_date" class="form-control" value="{{ old('target_due_date') }}" required>
            @error('target_due_date')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="link">Link</label>
            <input type="url" name="link" id="link" class="form-control" value="{{ old('link') }}" placeholder="https://example.com">
            @error('link')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.fitur.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
