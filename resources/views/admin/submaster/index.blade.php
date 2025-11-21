@extends('layouts.admin')

@section('title', 'Kelola Sub Master')
@section('header', 'Kelola Sub Master')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Daftar Sub Master</h2>
        <a href="{{ route('admin.submaster.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Sub Master
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Master</th>
                    <th>Nama Sub Master</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submasters as $submaster)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $submaster->master->nama ?? '-' }}</td>
                    <td>{{ $submaster->nama }}</td>
                    <td>{{ $submaster->deadline ? $submaster->deadline->format('d M Y') : '-' }}</td>
                    <td>
                        @if($submaster->status == 'selesai')
                            <span style="background: #2ecc71; color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px;">Selesai</span>
                        @else
                            <span style="background: #f39c12; color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px;">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($submaster->file_path)
                            <a href="{{ route('download.file', ['type' => 'submaster', 'id' => $submaster->id]) }}" class="btn-secondary" style="padding: 2px 5px; font-size: 12px;">
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.submaster.edit', $submaster->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.submaster.destroy', $submaster->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                    <td colspan="7" style="text-align: center;">Belum ada data sub master.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
