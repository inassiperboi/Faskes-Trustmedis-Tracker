<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Implementasi Faskes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .progress-bar {
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        .calendar-day {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.75rem;
            cursor: pointer;
        }
        .calendar-day.today {
            background-color: #3b82f6;
            color: white;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Tambahan untuk responsivitas kalender pada mobile */
        @media (max-width: 640px) {
            .calendar-day {
                width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }
            .grid-cols-7 {
                gap: 0.5rem;
            }
        }
    </style>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <i class="fas fa-hospital text-2xl text-blue-600 mr-3"></i>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Dashboard Implementasi Faskes</h1>
                    <p class="text-sm text-gray-600">Kelola implementasi fasilitas kesehatan secara terpusat</p>
                </div>
            </div>

            <div class="flex items-center">
                <div class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full mr-4">
                    <i class="fas fa-user-circle mr-1"></i>
                    <span>Admin</span>
                </div>

                <button class="flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Logout
                </button>
            </div>
        </div>
    </header>

    <!-- Container untuk memberikan jarak lebih dari pinggir body -->
    <div class="container mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-8">

            <!-- LEFT: Faskes List -->
            <div class="md:col-span-3 space-y-6">

                <section class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-list text-blue-600 mr-2"></i>
                            Daftar Faskes
                        </h2>

                        <!-- Tombol untuk membuka modal -->
                        <button onclick="toggleModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Faskes
                        </button>
                    </div>

                    <div class="p-4 md:p-6 space-y-6">

                        {{-- LOOP FASKES DARI DATABASE --}}
                        @foreach ($faskes as $item)
                            <div class="border border-gray-200 rounded-xl p-4 md:p-5 hover:shadow-lg transition duration-300 fade-in bg-white">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-hospital text-blue-500 mr-3 text-xl"></i>
                                            <h3 class="font-semibold text-lg md:text-xl text-gray-800">{{ $item->nama }}</h3>
                                        </div>

                                        <div class="mt-4 text-gray-600 space-y-2">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-tie mr-3 text-gray-500"></i>
                                                <span class="font-medium">PJ: <span class="text-gray-800">{{ $item->penanggung_jawab }}</span></span>
                                            </div>

                                            <div class="flex items-center">
                                                <i class="fas fa-users mr-3 text-gray-500"></i>
                                                <span class="font-medium">Tim: <span class="text-gray-800">{{ $item->tim }}</span></span>
                                            </div>
                                        </div>

                                        <div class="mt-5">
                                            <div class="flex justify-between text-sm mb-2">
                                                <span class="font-medium text-gray-700">Progress</span>
                                                <span class="font-semibold text-blue-600">{{ $item->progress }}%</span>
                                            </div>

                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: {{ $item->progress }}%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ url('/faskes/' . $item->id) }}"
                                       class="px-4 md:px-5 py-2 md:py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 flex items-center shadow-md">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </section>

            </div>

            <!-- RIGHT: Calendar & Timeline -->
            <div class="md:col-span-1 space-y-6">

                <!-- Calendar -->
                <section class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        Kalender Global
                    </h2>

                    <div class="mb-4 flex justify-between items-center">
                        <button class="p-1 rounded-full hover:bg-gray-100">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <span class="font-medium text-sm md:text-base">November 2025</span>

                        <button class="p-1 rounded-full hover:bg-gray-100">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-7 gap-1 mb-2 text-center text-xs text-gray-500">
                        <div>M</div><div>S</div><div>S</div><div>R</div><div>K</div><div>J</div><div>S</div>
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        <div class="calendar-day text-gray-300">29</div>
                        <div class="calendar-day text-gray-300">30</div>
                        <div class="calendar-day text-gray-300">31</div>
                        <div class="calendar-day">1</div>
                        <div class="calendar-day">2</div>
                        <div class="calendar-day">3</div>
                        <div class="calendar-day">4</div>

                        <div class="calendar-day">5</div>
                        <div class="calendar-day">6</div>
                        <div class="calendar-day">7</div>
                        <div class="calendar-day">8</div>
                        <div class="calendar-day">9</div>
                        <div class="calendar-day">10</div>
                        <div class="calendar-day">11</div>

                        <div class="calendar-day">12</div>
                        <div class="calendar-day">13</div>
                        <div class="calendar-day">14</div>
                        <div class="calendar-day">15</div>
                        <div class="calendar-day">16</div>
                        <div class="calendar-day">17</div>
                        <div class="calendar-day">18</div>

                        <div class="calendar-day">19</div>
                        <div class="calendar-day">20</div>
                        <div class="calendar-day">21</div>
                        <div class="calendar-day">22</div>
                        <div class="calendar-day">23</div>
                        <div class="calendar-day">24</div>
                        <div class="calendar-day">25</div>

                        <div class="calendar-day">26</div>
                        <div class="calendar-day">27</div>
                        <div class="calendar-day">28</div>
                        <div class="calendar-day">29</div>
                        <div class="calendar-day">30</div>
                        <div class="calendar-day text-gray-300">1</div>
                        <div class="calendar-day text-gray-300">2</div>
                    </div>
                </section>

                <!-- Timeline -->
                <section class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-stream text-blue-600 mr-2"></i>
                        Timeline Global
                    </h2>

                    <div class="space-y-3 max-h-64 md:max-h-96 overflow-y-auto">
                        <div class="border-l-2 border-blue-500 pl-3 py-1">
                            <div class="text-xs text-gray-500">20/07/2023 • RS Sehat Sentosa</div>
                            <div class="text-sm">Tahapan "Pembentukan Tim" diselesaikan</div>
                            <div class="text-xs text-gray-400">Oleh: Budi Santoso</div>
                        </div>

                        <div class="border-l-2 border-blue-500 pl-3 py-1">
                            <div class="text-xs text-gray-500">18/07/2023 • Puskesmas Harapan</div>
                            <div class="text-sm">Faskes Puskesmas Harapan dibuat</div>
                            <div class="text-xs text-gray-400">Oleh: Admin</div>
                        </div>

                        <div class="border-l-2 border-blue-500 pl-3 py-1">
                            <div class="text-xs text-gray-500">15/07/2023 • RS Sehat Sentosa</div>
                            <div class="text-sm">Faskes RS Sehat Sentosa dibuat</div>
                            <div class="text-xs text-gray-400">Oleh: Admin</div>
                        </div>
                    </div>
                </section>

            </div>

        </div>
    </div>

    <!-- Modal Popup untuk Tambah Faskes -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-xl w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-bold">Tambah Faskes</h1>
                <button onclick="toggleModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>

            <form action="{{ route('faskes.store') }}" method="POST">
                @csrf

                <label class="block mb-2">Nama Faskes</label>
                <input type="text" name="nama" placeholder="contoh: Rs Sehat sentosa" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2">Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" placeholder="Contoh: Nama penanggung jawab" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2">Tim (pisahkan dengan koma)</label>
                <textarea name="tim" placeholder="Contoh: Budi, Rina, Sinta" class="w-full border p-2 rounded mb-4"></textarea>

                <label class="block mb-2">Progress (%)</label>
                <input type="number" name="progress" min="0" max="100" class="w-full border p-2 rounded mb-4">

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="toggleModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>