@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
    <!-- Dashboard Cards -->
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-icon faskes">
                <i class="fas fa-clinic-medical fa-2x"></i>
            </div>
            <h3>Total Faskes</h3>
            <p>245</p>
        </div>
        <div class="card">
            <div class="card-icon master">
                <i class="fas fa-database fa-2x"></i>
            </div>
            <h3>Data Master</h3>
            <p>12</p>
        </div>
        <div class="card">
            <div class="card-icon submaster">
                <i class="fas fa-layer-group fa-2x"></i>
            </div>
            <h3>Sub Master</h3>
            <p>36</p>
        </div>
        <div class="card">
            <div class="card-icon subsections">
                <i class="fas fa-th-list fa-2x"></i>
            </div>
            <h3>Sub Sections</h3>
            <p>78</p>
        </div>
        <div class="card">
            <div class="card-icon users">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <h3>Total Users</h3>
            <p>{{ \App\Models\User::count() }}</p>
        </div>
    </div>

    <!-- Recent Faskes Section -->
    <div class="content-section">
        <div class="section-header">
            <h2>Faskes Terbaru</h2>
            <button class="btn btn-primary">Lihat Semua</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Faskes</th>
                    <th>Jenis</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>RS Umum Sentra Medika</td>
                    <td>Rumah Sakit</td>
                    <td>Jakarta Pusat</td>
                    <td><span style="color: var(--success);">Aktif</span></td>
                    <td class="action-buttons">
                        <button class="btn-edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Puskesmas Cempaka Putih</td>
                    <td>Puskesmas</td>
                    <td>Jakarta Pusat</td>
                    <td><span style="color: var(--success);">Aktif</span></td>
                    <td class="action-buttons">
                        <button class="btn-edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Klinik Sehat Sentosa</td>
                    <td>Klinik</td>
                    <td>Jakarta Barat</td>
                    <td><span style="color: var(--warning);">Pending</span></td>
                    <td class="action-buttons">
                        <button class="btn-edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Recent Users Section -->
    <div class="content-section">
        <div class="section-header">
            <h2>User Terbaru</h2>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Lihat Semua</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\User::latest()->take(3)->get() as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->jabatan }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn-edit"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
