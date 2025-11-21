@extends('layouts.admin')

@section('header', 'Edit Master Tahapan')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Edit Master Tahapan</h2>
        <a href="{{ route('admin.master-tahapan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.master-tahapan.update', $masterTahapan->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Changed field name from nama_tahapan to nama -->
        <div class="form-group">
            <label for="nama">Nama Tahapan *</label>
            <input type="text" 
                   name="nama" 
                   id="nama" 
                   class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama', $masterTahapan->nama) }}"
                   required>
            @error('nama')
                <div style="color: #e74c3c; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Added urutan field -->
        <div class="form-group">
            <label for="urutan">Urutan Prioritas *</label>
            <input type="number" 
                   name="urutan" 
                   id="urutan" 
                   class="form-control @error('urutan') is-invalid @enderror" 
                   value="{{ old('urutan', $masterTahapan->urutan) }}"
                   min="0"
                   required>
            @error('urutan')
                <div style="color: #e74c3c; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Added keterangan field -->
        <div class="form-group">
            <label for="keterangan">Keterangan (Opsional)</label>
            <textarea name="keterangan" 
                      id="keterangan" 
                      class="form-control @error('keterangan') is-invalid @enderror" 
                      rows="4">{{ old('keterangan', $masterTahapan->keterangan) }}</textarea>
            @error('keterangan')
                <div style="color: #e74c3c; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <!-- Updated button text and added icon -->
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
