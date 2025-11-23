@extends('layouts.admin')

@section('header', 'Kelola Master')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Daftar Master</h2>
        <a href="{{ route('admin.master.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Master
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Faskes</th>
                    <th>Nama Master</th>
                    <th>Deadline</th>
                    <th>Catatan</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masters as $master)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $master->faskes->nama ?? '-' }}</td>
                    <td>{{ $master->nama }}</td>
                    <td>{{ $master->deadline ? $master->deadline->format('d M Y') : '-' }}</td>
                    <td>{{ Str::limit($master->catatan, 50) }}</td>
                    <td>
                        @if($master->file_path)
                            <a href="{{ route('download.file', ['type' => 'tahapan', 'id' => $master->id]) }}" class="btn-secondary" style="padding: 2px 5px; font-size: 12px;">
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.master.edit', $master->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.master.destroy', $master->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" style="display: inline;">
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
                    <td colspan="7" style="text-align: center;">Belum ada data master.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
