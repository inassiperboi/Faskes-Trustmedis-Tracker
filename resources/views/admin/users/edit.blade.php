@extends('layouts.admin')

@section('title', 'Edit User')
@section('header', 'Edit User')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h2>Form Edit User</h2>
        <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $user->name) }}">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $user->email) }}">
        </div>
        
        <div class="form-group">
            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" required value="{{ old('jabatan', $user->jabatan) }}">
        </div>
        
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
