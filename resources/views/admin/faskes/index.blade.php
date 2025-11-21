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
                    <td colspan="6" style="text-align: center;">Belum ada data faskes.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
