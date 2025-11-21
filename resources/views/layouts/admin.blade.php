<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Sistem Manajemen Faskes</title>
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2c3e50;
            --light: #ecf0f1;
            --danger: #e74c3c;
            --success: #2ecc71;
            --warning: #f39c12;
            --gray: #95a5a6;
            --dark: #34495e;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f7fa;
            color: #333;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: var(--secondary);
            color: white;
            transition: all 0.3s;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 20px;
            background: var(--primary-dark);
            display: flex;
            align-items: center;
        }
        
        .sidebar-header h3 {
            margin-left: 10px;
            font-weight: 600;
        }
        
        .sidebar-menu {
            padding: 15px 0;
        }
        
        .sidebar-menu ul {
            list-style: none;
        }
        
        .sidebar-menu li {
            padding: 10px 20px;
            transition: all 0.3s;
        }
        
        .sidebar-menu li.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--primary);
        }
        
        .sidebar-menu li:hover {
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
        }
        
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            font-size: 18px;
            width: 25px;
            text-align: center;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
            width: calc(100% - 250px);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: var(--secondary);
            font-size: 24px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .card-icon.faskes { background: var(--primary); }
        .card-icon.master { background: var(--success); }
        .card-icon.submaster { background: var(--warning); }
        .card-icon.subsections { background: var(--danger); }
        .card-icon.users { background: var(--gray); }
        
        .card h3 {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 5px;
        }
        
        .card p {
            font-size: 24px;
            font-weight: 600;
            color: var(--secondary);
        }
        
        /* Content Sections */
        .content-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .section-header h2 {
            color: var(--secondary);
            font-size: 20px;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--gray);
            color: white;
        }
        
        .btn-secondary:hover {
            background: var(--dark);
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        table th {
            background: #f8f9fa;
            color: var(--secondary);
            font-weight: 600;
        }
        
        table tr:hover {
            background: #f8f9fa;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-edit {
            background: var(--warning);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-delete {
            background: var(--danger);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--secondary);
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-header h3, .sidebar-menu span {
                display: none;
            }
            
            .sidebar-menu i {
                margin-right: 0;
                font-size: 20px;
            }
            
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
            
            .dashboard-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-hospital-alt fa-2x"></i>
            <h3>Admin Faskes</h3>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="{{ request()->routeIs('admin.faskes.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.faskes.index') }}">
                        <i class="fas fa-clinic-medical"></i>
                        <span>Kelola Faskes</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.master-tahapan.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master-tahapan.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Master Tahapan</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.master.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master.index') }}">
                        <i class="fas fa-database"></i>
                        <span>Kelola Master</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.submaster.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.submaster.index') }}">
                        <i class="fas fa-layer-group"></i>
                        <span>Kelola Sub Master</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.subsection.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subsection.index') }}">
                        <i class="fas fa-th-list"></i>
                        <span>Kelola Sub Sections</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.fitur.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.fitur.index') }}">
                        <i class="fas fa-star"></i>
                        <span>Kelola Fitur</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Kelola Users</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>@yield('header', 'Dashboard Admin')</h1>
            <div class="user-info">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=3498db&color=fff" alt="Admin">
                <span>{{ Auth::user()->name ?? 'Admin Faskes' }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script>
        // Simple script for sidebar menu interaction
        document.addEventListener('DOMContentLoaded', function() {
            // You can add global scripts here
        });
    </script>
</body>
</html>
