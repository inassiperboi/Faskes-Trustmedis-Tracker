@extends('layouts.admin')

@section('title', 'Tambah Faskes')
@section('header', 'Tambah Faskes Baru')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Tambah Faskes</h2>
        <a href="{{ route('admin.faskes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.faskes.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="nama">Nama Faskes</label>
            <input type="text" name="nama" id="nama" class="form-control" required value="{{ old('nama') }}" placeholder="Contoh: RSUD Dr. Soetomo">
        </div>

        <div class="form-group">
            <label for="penanggung_jawab">APO (Penanggung Jawab)</label>
            <select name="penanggung_jawab" id="penanggung_jawab" class="form-control" required>
                <option value="">-- Pilih APO --</option>
                @foreach($users as $user)
                    <option value="{{ $user->name }}" {{ old('penanggung_jawab') == $user->name ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tim">Tim (Bisa pilih lebih dari satu)</label>
            <select name="tim[]" id="tim" class="form-control" multiple style="height: 150px;">
                @foreach($users as $user)
                    <option value="{{ $user->name }}" {{ (collect(old('tim'))->contains($user->name)) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Tahan tombol Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</small>
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan...">{{ old('catatan') }}</textarea>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Simpan Faskes</button>
        </div>
    </form>
</div>
@endsection
