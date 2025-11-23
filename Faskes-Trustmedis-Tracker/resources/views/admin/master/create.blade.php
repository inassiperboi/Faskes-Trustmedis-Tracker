@extends('layouts.admin')

@section('header', 'Tambah Master')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Tambah Master</h2>
        <a href="{{ route('admin.master.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.master.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="faskes_id">Faskes</label>
            <select name="faskes_id" id="faskes_id" class="form-control" required>
                <option value="">-- Pilih Faskes --</option>
                @foreach($faskes as $f)
                    <option value="{{ $f->id }}">{{ $f->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nama">Nama Master</label>
            <input type="text" name="nama" id="nama" class="form-control" required placeholder="Masukkan nama master/tahapan">
        </div>

        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Masukkan catatan (opsional)"></textarea>
        </div>

        <div class="form-group">
            <label for="file">Upload File (Opsional)</label>
            <input type="file" name="file" id="file" class="form-control">
            <small style="color: #666;">Format: PDF, Doc, Excel, Gambar (Max 10MB)</small>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
