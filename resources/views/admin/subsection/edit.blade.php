@extends('layouts.admin')

@section('title', 'Edit Sub Section')
@section('header', 'Edit Sub Section')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Edit Sub Section</h2>
        <a href="{{ route('admin.subsection.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.subsection.update', $subsection->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="sub_master_id">Sub Master</label>
            <select name="sub_master_id" id="sub_master_id" class="form-control" required>
                <option value="">-- Pilih Sub Master --</option>
                @foreach($submasters as $submaster)
                    <option value="{{ $submaster->id }}" {{ (old('sub_master_id') ?? $subsection->sub_master_id) == $submaster->id ? 'selected' : '' }}>
                        {{ $submaster->nama }} (Master: {{ $submaster->master->nama ?? '-' }})
                    </option>
                @endforeach
            </select>
            @error('sub_master_id')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama">Nama Sub Section</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $subsection->nama) }}" required>
            @error('nama')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $subsection->deadline ? $subsection->deadline->format('Y-m-d') : '') }}" required>
            @error('deadline')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ (old('status') ?? $subsection->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="selesai" {{ (old('status') ?? $subsection->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $subsection->catatan) }}</textarea>
            @error('catatan')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="file">Upload File (Opsional)</label>
            @if($subsection->file_path)
                <div style="margin-bottom: 5px;">
                    <small>File saat ini: <a href="{{ route('download.file', ['type' => 'subsection', 'id' => $subsection->id]) }}">{{ $subsection->file_original_name }}</a></small>
                </div>
            @endif
            <input type="file" name="file" id="file" class="form-control">
            <small style="color: #666;">Biarkan kosong jika tidak ingin mengubah file. Maksimal 10MB.</small>
            @error('file')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
