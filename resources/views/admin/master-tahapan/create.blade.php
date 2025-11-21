@extends('layouts.admin')

@section('header', 'Tambah Master Tahapan')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Tambah Master Tahapan</h2>
        <a href="{{ route('admin.master-tahapan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.master-tahapan.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama">Nama Tahapan *</label>
            <input type="text" 
                   name="nama" 
                   id="nama" 
                   class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama') }}"
                   placeholder="Contoh: Persiapan Dokumen Awal"
                   required>
            @error('nama')
                <div style="color: #e74c3c; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="urutan">Urutan Prioritas *</label>
            <input type="number" 
                   name="urutan" 
                   id="urutan" 
                   class="form-control @error('urutan') is-invalid @enderror" 
                   value="{{ old('urutan', 0) }}"
                   min="0"
                   required>
            @error('urutan')
                <div style="color: #e74c3c; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
            <small style="color: #666;">Angka lebih kecil akan ditampilkan lebih awal (0, 1, 2, dst)</small>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan (Opsional)</label>
            <textarea name="keterangan" 
                      id="keterangan" 
                      class="form-control @error('keterangan') is-invalid @enderror" 
                      rows="4"
                      placeholder="Deskripsi detail tentang apa yang perlu dilakukan pada tahapan ini...">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <div style="color: #e74c3c; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Tahapan
            </button>
        </div>
    </form>
</div>
@endsection