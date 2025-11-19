<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Faskes - Dashboard Implementasi Faskes</title>
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
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.7rem;
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
        .hierarchy-item {
            border-left: 3px solid #e5e7eb;
            padding-left: 1rem;
            margin-left: 1rem;
        }
        .hierarchy-item.completed {
            border-left-color: #10b981;
        }
        .hierarchy-item.in-progress {
            border-left-color: #f59e0b;
        }
        .hierarchy-item.not-started {
            border-left-color: #ef4444;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.375rem;
        }
        .badge-submaster {
            background-color: #f3e8ff;
            color: #7e22ce;
        }
        .badge-subsection {
            background-color: #dcfce7;
            color: #166534;
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
        // Modal untuk Tambah Tahapan
        function toggleModalTahapan() {
            const modal = document.getElementById('modal-tahapan');
            modal.classList.toggle('hidden');
        }

        // Modal untuk Tambah Sub Master
        function toggleModalSubMaster(masterId) {
            // Set master_id ke form
            document.getElementById('submaster_master_id').value = masterId;
            const modal = document.getElementById('modal-submaster');
            modal.classList.toggle('hidden');
        }

        // Modal untuk Tambah Sub Section
        function toggleModalSubSection(subMasterId) {
            document.getElementById('subsection_sub_master_id').value = subMasterId;
            const modal = document.getElementById('modal-subsection');
            modal.classList.toggle('hidden');
        }

        // Highlight today's date in calendar
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const currentMonth = 10; // November (0-indexed)
            const currentYear = 2025;
            
            // Only highlight if we're in November 2025
            if (today.getMonth() === currentMonth && today.getFullYear() === currentYear) {
                const dayElements = document.querySelectorAll('.calendar-day');
                dayElements.forEach(day => {
                    if (parseInt(day.textContent) === today.getDate() && !day.classList.contains('text-gray-300')) {
                        day.classList.add('today');
                    }
                });
            }
        });
    </script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Header/Navbar -->
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

            <!-- LEFT: Detail Faskes & Tahapan -->
            <div class="md:col-span-3 space-y-6">

                {{-- Breadcrumb & Kembali --}}
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <a href="{{ route('dashboard') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Dashboard
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800 font-medium">Detail Faskes</span>
                </div>

                {{-- DETAIL FASKES --}}
                <section class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold">{{ $faskes->nama }}</h2>

                        <div class="flex flex-wrap gap-4 mt-3 text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie text-blue-600 mr-2"></i>
                                Penanggung Jawab:
                                <span class="ml-1 font-semibold">{{ $faskes->penanggung_jawab }}</span>
                            </div>

                            <div class="flex items-center">
                                <i class="fas fa-users text-green-600 mr-2"></i>
                                Tim:
                                <span class="ml-1 font-semibold">{{ $faskes->tim ?? '-' }}</span>
                            </div>

                            <div class="flex items-center">
                                <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                                Progress:
                                <span class="ml-1 font-semibold">{{ $faskes->progress }}%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tahapan (MASTER) --}}
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-project-diagram text-blue-600 mr-2"></i>
                                Tahapan Implementasi
                            </h3>

                            <!-- Tombol untuk membuka modal tambah tahapan -->
                            <button onclick="toggleModalTahapan()" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 flex items-center">
                                <i class="fas fa-plus mr-2"></i> Tambah Tahapan
                            </button>
                        </div>

                        {{-- LOOP MASTER TAHAPAN --}}
                        @forelse ($faskes->tahapan as $tahap)
                        <div class="hierarchy-item 
                            @if($tahap->progress == 100) completed
                            @elseif($tahap->progress > 0) in-progress  
                            @else not-started @endif p-4 rounded-lg border bg-white mb-4">

                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-tasks mr-2 
                                            @if($tahap->progress == 100) text-green-500
                                            @elseif($tahap->progress > 0) text-yellow-500 
                                            @else text-red-500 @endif">
                                        </i>
                                        <h3 class="font-semibold text-lg">{{ $tahap->nama }}</h3>
                                    </div>

                                    @if($tahap->deskripsi)
                                    <p class="text-sm text-gray-600 mt-1">{{ $tahap->deskripsi }}</p>
                                    @endif

                                    @if($tahap->deadline)
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar-day mr-1"></i>
                                        Deadline: {{ $tahap->deadline->format('d/m/Y') }}
                                    </div>
                                    @endif

                                    <div class="mt-3">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Progress</span>
                                            <span>{{ $tahap->progress }}%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $tahap->progress }}%"></div>
                                        </div>
                                    </div>

                                    {{-- TAMPILKAN FILE UPLOAD TAHAPAN DI SINI --}}
                                    @if($tahap->file_path)
                                    <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <i class="fas fa-paperclip text-blue-600 mr-3"></i>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-800">{{ $tahap->file_original_name }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <i class="fas fa-hdd mr-1"></i>{{ $tahap->file_size }}
                                                        <span class="mx-2">•</span>
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($tahap->created_at)->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('download.file', ['type' => 'tahapan', 'id' => $tahap->id]) }}" 
                                                   class="px-3 py-2 bg-blue-600 text-white rounded text-sm flex items-center hover:bg-blue-700 transition duration-300">
                                                    <i class="fas fa-download mr-2"></i> Download
                                                </a>
                                                <a href="{{ asset('storage/' . $tahap->file_path) }}" 
                                                   target="_blank" 
                                                   class="px-3 py-2 bg-green-600 text-white rounded text-sm flex items-center hover:bg-green-700 transition duration-300">
                                                    <i class="fas fa-eye mr-2"></i> Preview
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="flex flex-col space-y-2 ml-4">
                                    <button onclick="toggleModalSubMaster({{ $tahap->id }})" 
                                            class="px-3 py-1 bg-blue-600 text-white rounded text-sm flex items-center hover:bg-blue-700">
                                        <i class="fas fa-plus mr-1"></i> Sub
                                    </button>
                                    <button class="px-3 py-1 bg-yellow-500 text-white rounded text-sm flex items-center">
                                        <i class="fas fa-sticky-note mr-1"></i> Catatan
                                    </button>
                                    <button class="px-3 py-1 bg-purple-600 text-white rounded text-sm flex items-center">
                                        <i class="fas fa-calendar-alt mr-1"></i> Deadline
                                    </button>
                                    <button class="px-3 py-1 bg-green-600 text-white rounded text-sm flex items-center">
                                        <i class="fas fa-check mr-1"></i> Submit
                                    </button>
                                </div>
                            </div>

                            {{-- LOOP SUB MASTERS --}}
                            <div class="mt-4 space-y-3">
                                @forelse ($tahap->submasters as $submaster)
                                <div class="hierarchy-item 
                                    @if($submaster->progress == 100) completed
                                    @elseif($submaster->progress > 0) in-progress  
                                    @else not-started @endif p-3 rounded border">

                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-th-list mr-2 
                                                    @if($submaster->progress == 100) text-green-500
                                                    @elseif($submaster->progress > 0) text-yellow-500 
                                                    @else text-red-500 @endif">
                                                </i>
                                                <h4 class="font-medium">{{ $submaster->nama }}</h4>
                                                <span class="badge badge-submaster ml-2">sub-master</span>
                                            </div>

                                            @if($submaster->deadline)
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-day mr-1"></i>
                                                Deadline: {{ $submaster->deadline->format('d/m/Y') }}
                                            </div>
                                            @endif

                                            <div class="mt-2">
                                                <div class="flex justify-between text-xs mb-1">
                                                    <span>Progress</span>
                                                    <span>{{ $submaster->progress }}%</span>
                                                </div>
                                                <div class="progress-bar">
                                                    <div class="progress-fill" style="width: {{ $submaster->progress }}%"></div>
                                                </div>
                                            </div>

                                            {{-- TAMPILKAN FILE UPLOAD SUBMASTER DI SINI --}}
                                            @if($submaster->file_path)
                                            <div class="mt-2 p-2 bg-green-50 rounded border border-green-200">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-paperclip text-green-600 mr-2"></i>
                                                        <div>
                                                            <div class="text-xs font-medium text-gray-800">{{ $submaster->file_original_name }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                <i class="fas fa-hdd mr-1"></i>{{ $submaster->file_size }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('download.file', ['type' => 'submaster', 'id' => $submaster->id]) }}" 
                                                       class="px-2 py-1 bg-green-600 text-white rounded text-xs flex items-center hover:bg-green-700">
                                                        <i class="fas fa-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="flex flex-col space-y-2 ml-4">
                                            <button onclick="toggleModalSubSection({{ $submaster->id }})" 
                                                    class="px-2 py-1 bg-blue-500 text-white rounded text-xs flex items-center hover:bg-blue-600">
                                                <i class="fas fa-plus mr-1"></i> Sub Section
                                            </button>
                                            <button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs flex items-center">
                                                <i class="fas fa-sticky-note mr-1"></i> Catatan
                                            </button>
                                            <button class="px-2 py-1 bg-purple-600 text-white rounded text-xs flex items-center">
                                                <i class="fas fa-calendar-alt mr-1"></i> Deadline
                                            </button>
                                            <button class="px-2 py-1 bg-green-600 text-white rounded text-xs flex items-center">
                                                <i class="fas fa-check mr-1"></i> Submit
                                            </button>
                                        </div>
                                    </div>

                                    {{-- LOOP SUB SECTIONS --}}
                                    <div class="mt-3 space-y-2">
                                        @forelse ($submaster->subsections as $subsection)
                                        <div class="hierarchy-item 
                                            @if($subsection->progress == 100) completed
                                            @elseif($subsection->progress > 0) in-progress  
                                            @else not-started @endif p-2 rounded border bg-gray-50">

                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-circle mr-2 
                                                            @if($subsection->progress == 100) text-green-500
                                                            @elseif($subsection->progress > 0) text-yellow-500 
                                                            @else text-red-500 @endif" style="font-size: 0.5rem;">
                                                        </i>
                                                        <h5 class="font-medium text-sm">{{ $subsection->nama }}</h5>
                                                        <span class="badge badge-subsection ml-2">sub-section</span>
                                                    </div>

                                                    @if($subsection->deadline)
                                                    <div class="mt-1 flex items-center text-xs text-gray-500">
                                                        <i class="fas fa-calendar-day mr-1"></i>
                                                        Deadline: {{ $subsection->deadline->format('d/m/Y') }}
                                                    </div>
                                                    @endif

                                                    <div class="mt-2">
                                                        <div class="flex justify-between text-xs mb-1">
                                                            <span>Progress</span>
                                                            <span>{{ $subsection->progress }}%</span>
                                                        </div>
                                                        <div class="progress-bar">
                                                            <div class="progress-fill" style="width: {{ $subsection->progress }}%"></div>
                                                        </div>
                                                    </div>

                                                    {{-- TAMPILKAN FILE UPLOAD SUBSECTION DI SINI --}}
                                                    @if($subsection->file_path)
                                                    <div class="mt-2 p-2 bg-purple-50 rounded border border-purple-200">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center">
                                                                <i class="fas fa-paperclip text-purple-600 mr-2"></i>
                                                                <div>
                                                                    <div class="text-xs font-medium text-gray-800">{{ $subsection->file_original_name }}</div>
                                                                    <div class="text-xs text-gray-500">
                                                                        <i class="fas fa-hdd mr-1"></i>{{ $subsection->file_size }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('download.file', ['type' => 'subsection', 'id' => $subsection->id]) }}" 
                                                               class="px-2 py-1 bg-purple-600 text-white rounded text-xs flex items-center hover:bg-purple-700">
                                                                <i class="fas fa-download mr-1"></i> Download
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="flex flex-col space-y-1 ml-4">
                                                    <button class="px-1 py-0.5 bg-yellow-500 text-white rounded text-xs flex items-center">
                                                        <i class="fas fa-sticky-note mr-0.5"></i> Note
                                                    </button>
                                                    <button class="px-1 py-0.5 bg-purple-600 text-white rounded text-xs flex items-center">
                                                        <i class="fas fa-calendar-alt mr-0.5"></i> Due
                                                    </button>
                                                    <button class="px-1 py-0.5 bg-green-600 text-white rounded text-xs flex items-center">
                                                        <i class="fas fa-check mr-0.5"></i> Done
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center py-2 text-gray-400 text-xs">
                                            <i class="fas fa-inbox mr-1"></i>
                                            <span>Belum ada sub-section</span>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-gray-500 text-sm">
                                    <i class="fas fa-inbox text-2xl mb-2"></i>
                                    <p>Belum ada sub-master.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-tasks text-4xl mb-4"></i>
                            <p>Belum ada tahapan. Mulai dengan menambahkan tahapan pertama!</p>
                        </div>
                        @endforelse
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

<!-- Modal Popup untuk Tambah Tahapan - UPDATE INI -->
<div id="modal-tahapan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 flex-shrink-0">
            <h1 class="text-xl font-bold">Tambah Tahapan untuk: {{ $faskes->nama }}</h1>
            <button onclick="toggleModalTahapan()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <form action="{{ route('tahapan.store', $faskes->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label class="block mb-2">Nama Tahapan</label>
                <input type="text" name="nama" placeholder="Contoh: Pembentukan Tim" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2">Deskripsi</label>
                <textarea name="deskripsi" placeholder="Deskripsi tahapan implementasi" class="w-full border p-2 rounded mb-4"></textarea>

                <label class="block mb-2">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2">Catatan</label>
                <textarea name="catatan" placeholder="Catatan tambahan" class="w-full border p-2 rounded mb-4"></textarea>

                <label class="block mb-2">Progress (%)</label>
                <input type="number" name="progress" min="0" max="100" placeholder="0" class="w-full border p-2 rounded mb-4">

                <!-- File Upload Section untuk TAHAPAN -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Upload File Submit</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition duration-300">
                        <input type="file" name="file" id="file-tahapan" class="hidden" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar">
                        <label for="file-tahapan" class="cursor-pointer block">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload file submit</p>
                            <p class="text-xs text-gray-400 mt-1">PDF, DOC, Excel, PPT, JPG, PNG, ZIP, RAR (max: 10MB)</p>
                        </label>
                        <div id="file-info-tahapan" class="mt-2 hidden">
                            <div class="flex items-center justify-between bg-green-50 p-2 rounded">
                                <div class="flex items-center">
                                    <i class="fas fa-file text-green-500 mr-2"></i>
                                    <span id="file-name-tahapan" class="text-sm font-medium"></span>
                                    <span id="file-size-tahapan" class="text-xs text-gray-500 ml-2"></span>
                                </div>
                                <button type="button" onclick="removeFile('tahapan')" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 mt-4 flex-shrink-0">
                    <button type="button" onclick="toggleModalTahapan()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Popup untuk Tambah Sub Master - UPDATE INI -->
<div id="modal-submaster" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 flex-shrink-0">
            <h1 class="text-xl font-bold">Tambah sub-master</h1>
            <button onclick="toggleModalSubMaster()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <form action="{{ route('submaster.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="master_id" id="submaster_master_id">

                <label class="block mb-2">Nama sub-master *</label>
                <input type="text" name="nama" placeholder="Contoh: Penyusunan Dokumen" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2">Catatan</label>
                <textarea name="catatan" placeholder="Catatan tambahan" class="w-full border p-2 rounded mb-4" rows="3"></textarea>

                <label class="block mb-2">Progress (%)</label>
                <input type="number" name="progress" min="0" max="100" value="0" class="w-full border p-2 rounded mb-4">

                <!-- File Upload Section untuk SUBMASTER -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Upload File Submit</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition duration-300">
                        <input type="file" name="file" id="file-submaster" class="hidden" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar">
                        <label for="file-submaster" class="cursor-pointer block">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload file submit</p>
                            <p class="text-xs text-gray-400 mt-1">PDF, DOC, Excel, PPT, JPG, PNG, ZIP, RAR (max: 10MB)</p>
                        </label>
                        <div id="file-info-submaster" class="mt-2 hidden">
                            <div class="flex items-center justify-between bg-green-50 p-2 rounded">
                                <div class="flex items-center">
                                    <i class="fas fa-file text-green-500 mr-2"></i>
                                    <span id="file-name-submaster" class="text-sm font-medium"></span>
                                    <span id="file-size-submaster" class="text-xs text-gray-500 ml-2"></span>
                                </div>
                                <button type="button" onclick="removeFile('submaster')" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 mt-4 flex-shrink-0">
                    <button type="button" onclick="toggleModalSubMaster()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan sub-master
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Popup untuk Tambah Sub Section - UPDATE INI -->
<div id="modal-subsection" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 flex-shrink-0">
            <h1 class="text-xl font-bold">Tambah Sub-section</h1>
            <button onclick="toggleModalSubSection()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <form action="{{ route('subsection.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sub_master_id" id="subsection_sub_master_id">

                <label class="block mb-2">Nama Sub-section *</label>
                <input type="text" name="nama" placeholder="Contoh: Analisis Kebutuhan" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2">Catatan</label>
                <textarea name="catatan" placeholder="Catatan tambahan" class="w-full border p-2 rounded mb-4" rows="3"></textarea>

                <label class="block mb-2">Progress (%)</label>
                <input type="number" name="progress" min="0" max="100" value="0" class="w-full border p-2 rounded mb-4">

                <!-- File Upload Section untuk SUBSECTION -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Upload File Submit</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition duration-300">
                        <input type="file" name="file" id="file-subsection" class="hidden" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar">
                        <label for="file-subsection" class="cursor-pointer block">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload file submit</p>
                            <p class="text-xs text-gray-400 mt-1">PDF, DOC, Excel, PPT, JPG, PNG, ZIP, RAR (max: 10MB)</p>
                        </label>
                        <div id="file-info-subsection" class="mt-2 hidden">
                            <div class="flex items-center justify-between bg-green-50 p-2 rounded">
                                <div class="flex items-center">
                                    <i class="fas fa-file text-green-500 mr-2"></i>
                                    <span id="file-name-subsection" class="text-sm font-medium"></span>
                                    <span id="file-size-subsection" class="text-xs text-gray-500 ml-2"></span>
                                </div>
                                <button type="button" onclick="removeFile('subsection')" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 mt-4 flex-shrink-0">
                    <button type="button" onclick="toggleModalSubSection()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan Sub-section
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
    // Function untuk handle file upload preview
    function handleFileUpload(type) {
        const fileInput = document.getElementById(`file-${type}`);
        const fileInfo = document.getElementById(`file-info-${type}`);
        const fileName = document.getElementById(`file-name-${type}`);
        const fileSize = document.getElementById(`file-size-${type}`);
        
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileInfo.classList.remove('hidden');
            }
        });
    }

    // Function untuk remove file
    function removeFile(type) {
        const fileInput = document.getElementById(`file-${type}`);
        const fileInfo = document.getElementById(`file-info-${type}`);
        
        fileInput.value = '';
        fileInfo.classList.add('hidden');
    }

    // Function untuk format file size
    function formatFileSize(bytes) {
        if (bytes >= 1073741824) {
            return (bytes / 1073741824).toFixed(2) + ' GB';
        } else if (bytes >= 1048576) {
            return (bytes / 1048576).toFixed(2) + ' MB';
        } else if (bytes >= 1024) {
            return (bytes / 1024).toFixed(2) + ' KB';
        } else {
            return bytes + ' bytes';
        }
    }

    // Initialize file upload handlers
    document.addEventListener('DOMContentLoaded', function() {
        handleFileUpload('tahapan');
        handleFileUpload('submaster');
        handleFileUpload('subsection');
    });
    </script>
</body>
</html>