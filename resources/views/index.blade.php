<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Implementasi Faskes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 text-gray-800">
    <section id="loginPage" class="min-h-screen flex flex-col justify-center items-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="text-center mb-8">
                <i class="fas fa-hospital text-4xl text-blue-600 mb-4"></i>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Implementasi Faskes</h1>
                <p class="text-gray-600 mt-2">Silakan pilih peran untuk melanjutkan</p>
            </div>
            
            <div class="space-y-4">
                <button onclick="login('Admin')" class="w-full flex items-center justify-center p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-user-shield mr-3"></i>
                    <div class="text-left">
                        <div class="font-semibold">Admin</div>
                        <div class="text-sm opacity-80">Akses penuh - dapat menambah, mengedit, menghapus</div>
                    </div>
                </button>
                
                <button onclick="login('Member')" class="w-full flex items-center justify-center p-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    <i class="fas fa-user mr-3"></i>
                    <div class="text-left">
                        <div class="font-semibold">Member</div>
                        <div class="text-sm opacity-80">Dapat mengedit dan menambah data</div>
                    </div>
                </button>
                
                <button onclick="login('Guest')" class="w-full flex items-center justify-center p-4 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300">
                    <i class="fas fa-eye mr-3"></i>
                    <div class="text-left">
                        <div class="font-semibold">Guest</div>
                        <div class="text-sm opacity-80">Hanya dapat melihat data</div>
                    </div>
                </button>
            </div>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>Dashboard ini membantu mengelola implementasi fasilitas kesehatan</p>
            </div>
        </div>
    </section>

    <script>
        function login(role) {
            // Simpan role ke localStorage
            localStorage.setItem('currentRole', role);
            // Redirect ke dashboard
            window.location.href = "{{ route('dashboard') }}";
        }
    </script>
</body>
</html>