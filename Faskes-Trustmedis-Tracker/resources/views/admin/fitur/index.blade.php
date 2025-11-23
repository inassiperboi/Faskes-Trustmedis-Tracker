@extends('layouts.admin')

@section('header', 'Kelola Fitur')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Daftar Fitur</h2>
        <a href="{{ route('admin.fitur.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Fitur
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Assessment</th>
                    <th>Judul</th>
                    <th>Target UAT</th>
                    <th>Target Due Date</th>
                    <th>Link</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fiturs as $fitur)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $fitur->no_assessment }}</td>
                    <td>{{ Str::limit($fitur->judul, 50) }}</td>
                    <td>{{ $fitur->target_uat ? $fitur->target_uat->format('d M Y') : '-' }}</td>
                    <td>{{ $fitur->target_due_date ? $fitur->target_due_date->format('d M Y') : '-' }}</td>
                    <td>
                        @if($fitur->link)
                            <a href="{{ $fitur->link }}" target="_blank" class="btn-secondary" style="padding: 2px 5px; font-size: 12px;">
                                <i class="fas fa-external-link-alt"></i> Link
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.fitur.edit', $fitur->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.fitur.destroy', $fitur->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" style="display: inline;">
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
                    <td colspan="7" style="text-align: center;">Belum ada data fitur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
