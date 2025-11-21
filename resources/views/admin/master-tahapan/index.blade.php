@extends('layouts.admin')

@section('header', 'Master Tahapan')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Daftar Master Tahapan</h2>
        <a href="{{ route('admin.master-tahapan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Master Tahapan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Urutan</th>
                    <th>Nama Tahapan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masterTahapan as $tahapan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $tahapan->urutan }}</td>
                    <td>{{ $tahapan->nama }}</td>
                    <td>{{ $tahapan->keterangan ?? '-' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.master-tahapan.edit', $tahapan->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.master-tahapan.destroy', $tahapan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data master tahapan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Informasi Sistem -->
    <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 4px; border-left: 4px solid #2196f3;">
        <h6 style="margin: 0 0 5px 0; color: #1976d2; font-weight: bold;">
            <i class="fas fa-info-circle"></i> Informasi Sistem
        </h6>
        <p style="margin: 0; font-size: 14px; color: #555;">
            Master Tahapan adalah template. Perubahan di sini hanya akan berpengaruh pada <strong>Faskes yang baru dibuat</strong>. 
            Faskes yang sudah ada tidak akan berubah.
        </p>
    </div>
</div>
@endsection