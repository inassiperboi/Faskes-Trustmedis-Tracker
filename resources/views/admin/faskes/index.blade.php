@extends('layouts.admin')

@section('title', 'Kelola Faskes')
@section('header', 'Kelola Data Faskes')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Daftar Faskes</h2>
        <a href="{{ route('admin.faskes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Faskes
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Faskes</th>
                    <th>APO</th>
                    <th>Tim</th>
                    {{-- Menambahkan kolom Progress% --}}
                    <th>Progress%</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faskes as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->penanggung_jawab }}</td>
                    <td>{{ Str::limit($item->tim, 50) }}</td>
                    {{-- Menampilkan persentase progress dengan styling --}}
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; background: #e0e0e0; border-radius: 10px; height: 20px; overflow: hidden;">
                                <div style="background: {{ $item->progress_percentage >= 100 ? '#4caf50' : ($item->progress_percentage >= 50 ? '#2196f3' : '#ff9800') }}; 
                                            height: 100%; 
                                            width: {{ $item->progress_percentage }}%; 
                                            transition: width 0.3s ease;">
                                </div>
                            </div>
                            <span style="font-weight: bold; min-width: 50px;">{{ number_format($item->progress_percentage, 0) }}%</span>
                        </div>
                    </td>
                    <td>{{ Str::limit($item->catatan, 50) }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.faskes.edit', $item->id) }}" class="btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.faskes.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus faskes ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    {{-- Update colspan karena ada kolom baru --}}
                    <td colspan="7" style="text-align: center;">Belum ada data faskes.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
