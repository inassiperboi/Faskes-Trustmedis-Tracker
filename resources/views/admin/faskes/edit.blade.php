@extends('layouts.admin')

@section('title', 'Edit Faskes')
@section('header', 'Edit Data Faskes')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Edit Faskes</h2>
        <a href="{{ route('admin.faskes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.faskes.update', $faske->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nama">Nama Faskes</label>
            <input type="text" name="nama" id="nama" class="form-control" required value="{{ old('nama', $faske->nama) }}">
        </div>

        <div class="form-group">
            <label for="penanggung_jawab">APO (Penanggung Jawab)</label>
            <select name="penanggung_jawab" id="penanggung_jawab" class="form-control" required>
                <option value="">-- Pilih APO --</option>
                @foreach($users as $user)
                    <option value="{{ $user->name }}" {{ old('penanggung_jawab', $faske->penanggung_jawab) == $user->name ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tim">Tim (Bisa pilih lebih dari satu)</label>
            @php
                $currentTim = explode(', ', $faske->tim);
            @endphp
            <select name="tim[]" id="tim" class="form-control" multiple style="height: 150px;">
                @foreach($users as $user)
                    <option value="{{ $user->name }}" {{ (collect(old('tim', $currentTim))->contains($user->name)) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Tahan tombol Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</small>
        </div>

        <div class="form-group">
            <label for="progress">Progress (%)</label>
            <input type="number" name="progress" id="progress" class="form-control" min="0" max="100" value="{{ old('progress', $faske->progress) }}">
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $faske->catatan) }}</textarea>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Update Faskes</button>
        </div>
    </form>
</div>
@endsection
