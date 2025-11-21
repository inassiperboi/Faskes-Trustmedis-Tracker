@extends('layouts.admin')

@section('title', 'Edit Sub Master')
@section('header', 'Edit Sub Master')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Edit Sub Master</h2>
        <a href="{{ route('admin.submaster.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.submaster.update', $submaster->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="master_id">Master (Tahapan)</label>
            <select name="master_id" id="master_id" class="form-control" required>
                <option value="">-- Pilih Master --</option>
                @foreach($masters as $master)
                    <option value="{{ $master->id }}" {{ $submaster->master_id == $master->id ? 'selected' : '' }}>
                        {{ $master->nama }} ({{ $master->faskes->nama ?? '-' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nama">Nama Sub Master</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $submaster->nama }}" required>
        </div>

        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ $submaster->deadline ? $submaster->deadline->format('Y-m-d') : '' }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ $submaster->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="selesai" {{ $submaster->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ $submaster->catatan }}</textarea>
        </div>

        <div class="form-group">
            <label for="file">Upload File (Biarkan kosong jika tidak ingin mengubah)</label>
            <input type="file" name="file" id="file" class="form-control">
            @if($submaster->file_path)
                <small style="display: block; margin-top: 5px;">File saat ini: <a href="{{ route('download.file', ['type' => 'submaster', 'id' => $submaster->id]) }}">{{ $submaster->file_original_name }}</a></small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
