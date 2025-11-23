@extends('layouts.admin')

@section('title', 'Kelola Users')
@section('header', 'Kelola Users')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Daftar Users</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role == 'admin')
                        <span style="color: var(--primary); font-weight: bold;">Admin</span>
                    @else
                        <span style="color: var(--secondary);">User</span>
                    @endif
                </td>
                <td>{{ $user->jabatan }}</td>
                <td class="action-buttons">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
