@extends('layouts.admin')

@section('header', 'Edit Master')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Edit Master</h2>
        <a href="{{ route('admin.master.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.master.update', $master->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="faskes_id">Faskes</label>
            <select name="faskes_id" id="faskes_id" class="form-control" required>
                <option value="">-- Pilih Faskes --</option>
                @foreach($faskes as $f)
                    <option value="{{ $f->id }}" {{ $master->faskes_id == $f->id ? 'selected' : '' }}>{{ $f->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nama">Nama Master</label>
            <input type="text" name="nama" id="nama" class="form-control" required value="{{ $master->nama }}">
        </div>

        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control" required value="{{ $master->deadline ? $master->deadline->format('Y-m-d') : '' }}">
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="4">{{ $master->catatan }}</textarea>
        </div>

        <div class="form-group">
            <label for="file">Upload File Baru (Opsional)</label>
            <input type="file" name="file" id="file" class="form-control">
            <small style="color: #666;">Biarkan kosong jika tidak ingin mengubah file.</small>
            @if($master->file_path)
                <div style="margin-top: 5px;">
                    File saat ini: <a href="{{ route('download.file', ['type' => 'tahapan', 'id' => $master->id]) }}" target="_blank">{{ $master->file_original_name }}</a>
                </div>
            @endif
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
    </form>
</div>
@endsection
