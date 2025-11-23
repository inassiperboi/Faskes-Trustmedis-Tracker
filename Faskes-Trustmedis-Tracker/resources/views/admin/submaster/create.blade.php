@extends('layouts.admin')

@section('title', 'Tambah Sub Master')
@section('header', 'Tambah Sub Master')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Tambah Sub Master</h2>
        <a href="{{ route('admin.submaster.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.submaster.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="master_id">Master (Tahapan)</label>
            <select name="master_id" id="master_id" class="form-control" required>
                <option value="">-- Pilih Master --</option>
                @foreach($masters as $master)
                    <option value="{{ $master->id }}">{{ $master->nama }} ({{ $master->faskes->nama ?? '-' }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nama">Nama Sub Master</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="file">Upload File (Opsional)</label>
            <input type="file" name="file" id="file" class="form-control">
            <small style="color: #666;">Maksimal 10MB</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
