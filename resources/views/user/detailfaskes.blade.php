<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Faskes - Dashboard Implementasi Faskes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    
    <style>
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
        
        /* Styles untuk kalender mini di detail faskes */
        #calendar-mini {
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
        }
        #calendar-mini .fc-header-toolbar {
            margin-bottom: 0.75em;
            font-size: 0.9rem;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            border-radius: 8px;
            padding: 0.5em;
        }
        #calendar-mini .fc-toolbar-title {
            font-size: 1rem;
            font-weight: bold;
        }
        #calendar-mini .fc-button {
            padding: 0.3em 0.6em;
            font-size: 0.8rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 6px;
            color: white;
            transition: background 0.3s ease;
        }
        #calendar-mini .fc-button:hover {
            background: rgba(255, 255, 255, 0.4);
        }
        #calendar-mini .fc-button:not(:disabled).fc-button-active {
            background: white;
            color: #3b82f6;
        }
        #calendar-mini .fc-daygrid-day-frame {
            min-height: 2.5rem;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        #calendar-mini .fc-daygrid-day:hover {
            background: #f0f9ff;
        }
        #calendar-mini .fc-daygrid-day-number {
            font-size: 0.8rem;
            padding: 4px;
            font-weight: 600;
        }
        #calendar-mini .fc-event {
            font-size: 0.7rem;
            padding: 2px 4px;
            margin: 2px 0;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        #calendar-mini .fc-event:hover {
            transform: scale(1.05);
        }
        #calendar-mini .fc-day-today {
            background: #dbeafe !important;
            border: 2px solid #3b82f6;
        }
        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 0.5rem;
            font-size: 0.8rem;
        }
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 0.4rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
    </style>
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
                    <span>{{ Auth::user()->name ?? 'User' }}</span>
                </div>

                {{-- Updated logout button to use form submission --}}
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
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
                        </div>
                    </div>

                    {{-- Tahapan (MASTER) --}}
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-project-diagram text-blue-600 mr-2"></i>
                                Tahapan Implementasi
                            </h3>

                            <!-- Removed the "Tambah Tahapan" button as requested -->
                        </div>

                        {{-- LOOP MASTER TAHAPAN --}}
                        @forelse ($faskes->tahapan as $tahap)
                        <div class="hierarchy-item p-4 rounded-lg border bg-white mb-4 fade-in">

                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-tasks text-blue-500 mr-2"></i>
                                        <h3 class="font-semibold text-lg">{{ $tahap->nama }}</h3>
                                    </div>

                                    @if($tahap->deadline)
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar-day mr-1"></i>
                                        Deadline: {{ $tahap->deadline->format('d/m/Y') }}
                                    </div>
                                    @endif

                                    @if($tahap->catatan)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600"><strong>Catatan:</strong> {{ $tahap->catatan }}</p>
                                    </div>
                                    @endif
                                </div>

                                <div class="flex flex-col space-y-2 ml-4">
                                    <button onclick="toggleModalSubMaster({{ $tahap->id }})" 
                                            class="px-3 py-1 bg-blue-600 text-white rounded text-sm flex items-center hover:bg-blue-700">
                                        <i class="fas fa-plus mr-1"></i> Sub
                                    </button>
                                    
                                    <!-- TOMBOL EDIT TAHAPAN -->
                                    <button onclick="toggleModalEditTahapan({{ $tahap->id }}, { 
                                        id: {{ $tahap->id }}, 
                                        nama: '{{ addslashes($tahap->nama) }}', 
                                        deadline: '{{ $tahap->deadline ? $tahap->deadline->format('Y-m-d') : '' }}', 
                                        catatan: '{{ addslashes($tahap->catatan ?? '') }}'
                                    })" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm flex items-center hover:bg-yellow-600">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                    
                                    <!-- TOMBOL HAPUS TAHAPAN -->
                                    <form action="{{ route('tahapan.destroy', $tahap->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-600 text-white rounded text-sm flex items-center hover:bg-red-700 w-full"
                                                onclick="return confirm('Yakin hapus tahapan {{ $tahap->nama }}?')">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- LOOP SUB MASTERS --}}
                            <div class="mt-4 space-y-3">
                                @forelse ($tahap->submasters as $submaster)
                                <div class="hierarchy-item p-3 rounded border">

                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-th-list mr-2 
                                                    @if($submaster->status == 'selesai') text-green-500
                                                    @else text-red-500 @endif">
                                                </i>
                                                <h4 class="font-medium">{{ $submaster->nama }}</h4>
                                                <span class="badge badge-submaster ml-2">sub-master</span>
                                                
                                                <!-- Status Badge untuk SubMaster -->
                                                <span class="ml-2 text-xs font-medium px-2 py-1 rounded-full 
                                                    @if($submaster->status == 'selesai') bg-green-100 text-green-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    <i class="fas fa-circle mr-1" style="font-size: 0.5rem;"></i>
                                                    {{ $submaster->status == 'selesai' ? 'Selesai' : 'Pending' }}
                                                </span>
                                            </div>

                                            @if($submaster->deadline)
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar-day mr-1"></i>
                                                Deadline: {{ $submaster->deadline->format('d/m/Y') }}
                                            </div>
                                            @endif

                                            @if($submaster->catatan)
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-600"><strong>Catatan:</strong> {{ $submaster->catatan }}</p>
                                            </div>
                                            @endif

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
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('download.file', ['type' => 'submaster', 'id' => $submaster->id]) }}" 
                                                           class="px-2 py-1 bg-green-600 text-white rounded text-xs flex items-center hover:bg-green-700">
                                                            <i class="fas fa-download mr-1"></i> Download
                                                        </a>
                                                        <!-- TOMBOL PREVIEW SUBMASTER -->
                                                        <a href="{{ route('preview.file', ['type' => 'submaster', 'id' => $submaster->id]) }}" 
                                                           target="_blank" 
                                                           class="px-2 py-1 bg-blue-600 text-white rounded text-xs flex items-center hover:bg-blue-700">
                                                            <i class="fas fa-eye mr-1"></i> Preview
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="flex flex-col space-y-2 ml-4">
                                            <button onclick="toggleModalSubSection({{ $submaster->id }})" 
                                                    class="px-2 py-1 bg-blue-500 text-white rounded text-xs flex items-center hover:bg-blue-600">
                                                <i class="fas fa-plus mr-1"></i> Sub Section
                                            </button>
                                            
                                            <!-- TOMBOL EDIT SUBMASTER -->
                                            <button onclick="toggleModalEditSubMaster({{ $submaster->id }}, { 
                                                id: {{ $submaster->id }}, 
                                                nama: '{{ addslashes($submaster->nama) }}', 
                                                deadline: '{{ $submaster->deadline ? $submaster->deadline->format('Y-m-d') : '' }}', 
                                                catatan: '{{ addslashes($submaster->catatan ?? '') }}',
                                                file_path: '{{ $submaster->file_path }}',
                                                file_original_name: '{{ addslashes($submaster->file_original_name ?? '') }}',
                                                file_size: '{{ addslashes($submaster->file_size ?? '') }}'
                                            })" class="px-2 py-1 bg-yellow-500 text-white rounded text-xs flex items-center hover:bg-yellow-600">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                            
                                            <!-- TOMBOL STATUS SUBMASTER -->
                                            @if($submaster->status == 'pending')
                                            <form action="{{ route('submaster.complete', $submaster->id) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" 
                                                        class="px-2 py-1 bg-green-600 text-white rounded text-xs flex items-center hover:bg-green-700 w-full"
                                                        onclick="return confirm('Tandai sub-master {{ $submaster->nama }} sebagai selesai?')">
                                                    <i class="fas fa-check mr-1"></i> Submit
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('submaster.pending', $submaster->id) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" 
                                                        class="px-2 py-1 bg-yellow-600 text-white rounded text-xs flex items-center hover:bg-yellow-700 w-full"
                                                        onclick="return confirm('Kembalikan status {{ $submaster->nama }} menjadi pending?')">
                                                    <i class="fas fa-undo mr-1"></i> Batal Submit
                                                </button>
                                            </form>
                                            @endif

                                            <!-- TOMBOL HAPUS SUBMASTER -->
                                            <form action="{{ route('submaster.destroy', $submaster->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="px-2 py-1 bg-red-600 text-white rounded text-xs flex items-center hover:bg-red-700 w-full"
                                                        onclick="return confirm('Yakin hapus submaster {{ $submaster->nama }}?')">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- LOOP SUB SECTIONS --}}
                                    <div class="mt-3 space-y-2">
                                        @forelse ($submaster->subsections as $subsection)
                                        <div class="hierarchy-item p-2 rounded border bg-gray-50">

                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-circle mr-2 
                                                            @if($subsection->status == 'selesai') text-green-500
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

                                                    {{-- TAMPILKAN CATATAN SUBSECTION DI SINI --}}
                                                    @if($subsection->catatan)
                                                    <div class="mt-1">
                                                        <p class="text-xs text-gray-600"><strong>Catatan:</strong> {{ $subsection->catatan }}</p>
                                                    </div>
                                                    @endif

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
                                                            <div class="flex space-x-2">
                                                                <a href="{{ route('download.file', ['type' => 'subsection', 'id' => $subsection->id]) }}" 
                                                                   class="px-2 py-1 bg-purple-600 text-white rounded text-xs flex items-center hover:bg-purple-700">
                                                                    <i class="fas fa-download mr-1"></i> Download
                                                                </a>
                                                                <!-- TOMBOL PREVIEW SUBSECTION -->
                                                                <a href="{{ route('preview.file', ['type' => 'subsection', 'id' => $subsection->id]) }}" 
                                                                   target="_blank" 
                                                                   class="px-2 py-1 bg-blue-600 text-white rounded text-xs flex items-center hover:bg-blue-700">
                                                                    <i class="fas fa-eye mr-1"></i> Preview
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="flex flex-col space-y-1 ml-4">
                                                    <!-- TOMBOL EDIT SUBSECTION -->
                                                    <button onclick="toggleModalEditSubSection({{ $subsection->id }}, { 
                                                        id: {{ $subsection->id }}, 
                                                        nama: '{{ addslashes($subsection->nama) }}', 
                                                        deadline: '{{ $subsection->deadline ? $subsection->deadline->format('Y-m-d') : '' }}', 
                                                        catatan: '{{ addslashes($subsection->catatan ?? '') }}', 
                                                        file_path: '{{ $subsection->file_path }}',
                                                        file_original_name: '{{ addslashes($subsection->file_original_name ?? '') }}',
                                                        file_size: '{{ addslashes($subsection->file_size ?? '') }}'
                                                    })" class="px-1 py-0.5 bg-yellow-500 text-white rounded text-xs flex items-center hover:bg-yellow-600">
                                                        <i class="fas fa-edit mr-0.5"></i> Edit
                                                    </button>
                                                    
                                                    <!-- TOMBOL SUBMIT SUBSECTION -->
                                                    @if($subsection->status == 'pending')
                                                    <form action="{{ route('subsection.complete', $subsection->id) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" 
                                                                class="px-1 py-0.5 bg-green-600 text-white rounded text-xs flex items-center hover:bg-green-700 w-full mb-1"
                                                                onclick="return confirm('Tandai sub-section {{ $subsection->nama }} sebagai selesai?')">
                                                            <i class="fas fa-check mr-0.5"></i> Submit
                                                        </button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('subsection.pending', $subsection->id) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" 
                                                                class="px-1 py-0.5 bg-yellow-600 text-white rounded text-xs flex items-center hover:bg-yellow-700 w-full mb-1"
                                                                onclick="return confirm('Kembalikan status {{ $subsection->nama }} menjadi pending?')">
                                                            <i class="fas fa-undo mr-0.5"></i> Batal Submit
                                                        </button>
                                                    </form>
                                                    @endif

                                                    <!-- Tampilkan status -->
                                                    <div class="mt-1">
                                                        <span class="text-xs font-medium px-2 py-1 rounded-full 
                                                            @if($subsection->status == 'selesai') bg-green-100 text-green-800
                                                            @else bg-yellow-100 text-yellow-800 @endif">
                                                            <i class="fas fa-circle mr-1" style="font-size: 0.5rem;"></i>
                                                            {{ $subsection->status == 'selesai' ? 'Selesai' : 'Pending' }}
                                                        </span>
                                                    </div>

                                                    <!-- TOMBOL HAPUS SUBSECTION -->
                                                    <form action="{{ route('subsection.destroy', $subsection->id) }}" method="POST" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" 
                                                                class="px-1 py-0.5 bg-red-600 text-white rounded text-xs flex items-center hover:bg-red-700 w-full"
                                                                onclick="return confirm('Yakin hapus sub-section {{ $subsection->nama }}?')">
                                                            <i class="fas fa-trash mr-0.5"></i> Hapus
                                                        </button>
                                                    </form>
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

                <!-- Calendar Global Dinamis -->
                <section class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                            Kalender Global
                        </h2>
                        <a href="{{ route('calendar.index') }}" 
                           class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded hover:bg-blue-200 transition duration-300">
                            Lihat Detail
                        </a>
                    </div>

                    <!-- Legend Mini -->
                    <div class="mb-3">
                        <div class="flex flex-wrap gap-2">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #3b82f6;"></div>
                                <span>Tahapan</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #10b981;"></div>
                                <span>Sub</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kalender Mini -->
                    <div id="calendar-mini"></div>
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

<!-- Modal Popup untuk Tambah Tahapan -->
<div id="modal-tahapan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 flex-shrink-0">
            <h1 class="text-xl font-bold">Tambah Tahapan untuk: {{ $faskes->nama }}</h1>
            <button onclick="toggleModalTahapan()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <form action="{{ route('tahapan.store', $faskes->id) }}" method="POST">
                @csrf

                <label class="block mb-2 font-medium">Nama Tahapan *</label>
                <input type="text" name="nama" placeholder="Contoh: Pembentukan Tim" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2 font-medium">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2 font-medium">Catatan</label>
                <textarea name="catatan" placeholder="Catatan tambahan" class="w-full border p-2 rounded mb-4" rows="4"></textarea>

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

<!-- Modal Popup untuk Tambah Sub Master -->
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

                <label class="block mb-2 font-medium">Nama sub-master *</label>
                <input type="text" name="nama" placeholder="Contoh: Penyusunan Dokumen" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2 font-medium">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2 font-medium">Catatan</label>
                <textarea name="catatan" placeholder="Catatan tambahan" class="w-full border p-2 rounded mb-4" rows="3"></textarea>

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

<!-- Modal Popup untuk Tambah Sub Section -->
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

                <label class="block mb-2 font-medium">Nama Sub-section *</label>
                <input type="text" name="nama" placeholder="Contoh: Analisis Kebutuhan" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2 font-medium">Deadline</label>
                <input type="date" name="deadline" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2 font-medium">Catatan</label>
                <textarea name="catatan" placeholder="Catatan tambahan" class="w-full border p-2 rounded mb-4" rows="3"></textarea>

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

<!-- Modal Edit untuk Tahapan -->
<div id="modal-edit-tahapan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 flex-shrink-0">
            <h1 class="text-xl font-bold">Edit Tahapan</h1>
            <button onclick="toggleModalEditTahapan()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <form id="form-edit-tahapan" action="" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="id" id="edit_tahapan_id">

                <label class="block mb-2 font-medium">Nama Tahapan</label>
                <input type="text" name="nama" id="edit_nama_tahapan" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2 font-medium">Deadline</label>
                <input type="date" name="deadline" id="edit_deadline_tahapan" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2 font-medium">Catatan</label>
                <textarea name="catatan" id="edit_catatan_tahapan" class="w-full border p-2 rounded mb-4" rows="4"></textarea>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 mt-4">
                    <button type="button" onclick="toggleModalEditTahapan()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Tahapan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit untuk SubMaster -->
<div id="modal-edit-submaster" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 flex-shrink-0">
            <h1 class="text-xl font-bold">Edit Sub-Master</h1>
            <button onclick="toggleModalEditSubMaster()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <form id="form-edit-submaster" action="" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="id" id="edit_submaster_id">

                <label class="block mb-2 font-medium">Nama Sub-Master</label>
                <input type="text" name="nama" id="edit_nama_submaster" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2 font-medium">Deadline</label>
                <input type="date" name="deadline" id="edit_deadline_submaster" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2 font-medium">Catatan</label>
                <textarea name="catatan" id="edit_catatan_submaster" class="w-full border p-2 rounded mb-4" rows="3"></textarea>

                <!-- Current File Info -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">File Saat Ini</label>
                    <div id="current-file-submaster" class="text-gray-500 text-sm">
                        <!-- File info akan diisi oleh JavaScript -->
                    </div>
                </div>

                <!-- New File Upload -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Upload File Baru (opsional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition duration-300">
                        <input type="file" name="file" class="w-full">
                        <p class="text-xs text-gray-400 mt-1">PDF, DOC, Excel, PPT, JPG, PNG, ZIP, RAR (max: 10MB)</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 mt-4">
                    <button type="button" onclick="toggleModalEditSubMaster()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Sub-Master
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit untuk SubSection -->
<div id="modal-edit-subsection" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-gray-200 flex-shrink-0">
            <h1 class="text-xl font-bold">Edit Sub-Section</h1>
            <button onclick="toggleModalEditSubSection()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <form id="form-edit-subsection" action="" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="id" id="edit_subsection_id">

                <label class="block mb-2 font-medium">Nama Sub-Section</label>
                <input type="text" name="nama" id="edit_nama_subsection" class="w-full border p-2 rounded mb-4" required>

                <label class="block mb-2 font-medium">Deadline</label>
                <input type="date" name="deadline" id="edit_deadline_subsection" class="w-full border p-2 rounded mb-4">

                <label class="block mb-2 font-medium">Catatan</label>
                <textarea name="catatan" id="edit_catatan_subsection" class="w-full border p-2 rounded mb-4" rows="3"></textarea>

                <!-- Current File Info -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">File Saat Ini</label>
                    <div id="current-file-subsection" class="text-gray-500 text-sm">
                        <!-- File info akan diisi oleh JavaScript -->
                    </div>
                </div>

                <!-- New File Upload -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700">Upload File Baru (opsional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition duration-300">
                        <input type="file" name="file" class="w-full">
                        <p class="text-xs text-gray-400 mt-1">PDF, DOC, Excel, PPT, JPG, PNG, ZIP, RAR (max: 10MB)</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200 mt-4">
                    <button type="button" onclick="toggleModalEditSubSection()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Sub-Section
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>
    
    <script>
        // Modal untuk Tambah Tahapan
        function toggleModalTahapan() {
            const modal = document.getElementById('modal-tahapan');
            modal.classList.toggle('hidden');
        }

        // Modal untuk Tambah Sub Master
        function toggleModalSubMaster(masterId) {
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

        // Modal untuk Edit Tahapan
        function toggleModalEditTahapan(tahapanId, tahapanData = null) {
            const modal = document.getElementById('modal-edit-tahapan');
            
            if (tahapanData) {
                document.getElementById('edit_tahapan_id').value = tahapanData.id;
                document.getElementById('edit_nama_tahapan').value = tahapanData.nama;
                document.getElementById('edit_deadline_tahapan').value = tahapanData.deadline || '';
                document.getElementById('edit_catatan_tahapan').value = tahapanData.catatan || '';
                
                // Set form action secara langsung - FIXED
                document.getElementById('form-edit-tahapan').action = `/tahapan/${tahapanData.id}`;
            }
            
            modal.classList.toggle('hidden');
        }

        // Modal untuk Edit SubMaster
        function toggleModalEditSubMaster(subMasterId, subMasterData = null) {
            const modal = document.getElementById('modal-edit-submaster');
            
            if (subMasterData) {
                document.getElementById('edit_submaster_id').value = subMasterData.id;
                document.getElementById('edit_nama_submaster').value = subMasterData.nama;
                document.getElementById('edit_deadline_submaster').value = subMasterData.deadline || '';
                document.getElementById('edit_catatan_submaster').value = subMasterData.catatan || '';
                
                // Set form action secara langsung - FIXED
                document.getElementById('form-edit-submaster').action = `/submaster/${subMasterData.id}`;
                
                const fileInfo = document.getElementById('current-file-submaster');
                if (subMasterData.file_path) {
                    fileInfo.innerHTML = `
                        <div class="flex items-center justify-between bg-green-50 p-2 rounded border border-green-200">
                            <div class="flex items-center">
                                <i class="fas fa-paperclip text-green-600 mr-2"></i>
                                <div>
                                    <div class="text-xs font-medium text-gray-800">${subMasterData.file_original_name}</div>
                                    <div class="text-xs text-gray-500">${subMasterData.file_size}</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="/download/submaster/${subMasterData.id}" 
                                   class="px-2 py-1 bg-green-600 text-white rounded text-xs flex items-center hover:bg-green-700">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                                <a href="/preview/submaster/${subMasterData.id}" 
                                   target="_blank"
                                   class="px-2 py-1 bg-blue-600 text-white rounded text-xs flex items-center hover:bg-blue-700">
                                    <i class="fas fa-eye mr-1"></i> Preview
                                </a>
                            </div>
                        </div>
                    `;
                } else {
                    fileInfo.innerHTML = '<p class="text-gray-500 text-xs">Tidak ada file</p>';
                }
            }
            
            modal.classList.toggle('hidden');
        }

        // Modal untuk Edit SubSection
        function toggleModalEditSubSection(subSectionId, subSectionData = null) {
            const modal = document.getElementById('modal-edit-subsection');
            
            if (subSectionData) {
                document.getElementById('edit_subsection_id').value = subSectionData.id;
                document.getElementById('edit_nama_subsection').value = subSectionData.nama;
                document.getElementById('edit_deadline_subsection').value = subSectionData.deadline || '';
                document.getElementById('edit_catatan_subsection').value = subSectionData.catatan || '';
                
                // Set form action secara langsung - FIXED
                document.getElementById('form-edit-subsection').action = `/subsection/${subSectionData.id}`;
                
                const fileInfo = document.getElementById('current-file-subsection');
                if (subSectionData.file_path) {
                    fileInfo.innerHTML = `
                        <div class="flex items-center justify-between bg-purple-50 p-2 rounded border border-purple-200">
                            <div class="flex items-center">
                                <i class="fas fa-paperclip text-purple-600 mr-2"></i>
                                <div>
                                    <div class="text-xs font-medium text-gray-800">${subSectionData.file_original_name}</div>
                                    <div class="text-xs text-gray-500">${subSectionData.file_size}</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="/download/subsection/${subSectionData.id}" 
                                   class="px-2 py-1 bg-purple-600 text-white rounded text-xs flex items-center hover:bg-purple-700">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                                <a href="/preview/subsection/${subSectionData.id}" 
                                   target="_blank"
                                   class="px-2 py-1 bg-blue-600 text-white rounded text-xs flex items-center hover:bg-blue-700">
                                    <i class="fas fa-eye mr-1"></i> Preview
                                </a>
                            </div>
                        </div>
                    `;
                } else {
                    fileInfo.innerHTML = '<p class="text-gray-500 text-xs">Tidak ada file</p>';
                }
            }
            
            modal.classList.toggle('hidden');
        }

        // Calendar initialization
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar-mini');
            
            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: ''
                    },
                    height: 'auto',
                    contentHeight: 'auto',
                    events: '{{ route("calendar.events") }}',
                    eventClick: function(info) {
                        if (info.event.url) {
                            window.location.href = info.event.url;
                        }
                    },
                    eventDidMount: function(info) {
                        // Tambahkan tooltip
                        info.el.title = info.event.title;
                        
                        // Highlight deadline yang mendekati (kurang dari 3 hari)
                        const eventDate = new Date(info.event.start);
                        const today = new Date();
                        const diffTime = eventDate - today;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        
                        if (diffDays <= 3 && diffDays >= 0) {
                            info.el.style.backgroundColor = '#ef4444';
                            info.el.style.borderColor = '#ef4444';
                            info.el.style.color = 'white';
                        }
                    },
                    dayMaxEvents: 2,
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false
                    }
                });
                
                calendar.render();
            }

            // Initialize file upload handlers
            handleFileUpload('submaster');
            handleFileUpload('subsection');
        });

        // Function untuk handle file upload preview
        function handleFileUpload(type) {
            const fileInput = document.getElementById(`file-${type}`);
            const fileInfo = document.getElementById(`file-info-${type}`);
            const fileName = document.getElementById(`file-name-${type}`);
            const fileSize = document.getElementById(`file-size-${type}`);
            
            if (fileInput && fileInfo && fileName && fileSize) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        fileName.textContent = file.name;
                        fileSize.textContent = formatFileSize(file.size);
                        fileInfo.classList.remove('hidden');
                    }
                });
            }
        }

        // Function untuk remove file
        function removeFile(type) {
            const fileInput = document.getElementById(`file-${type}`);
            const fileInfo = document.getElementById(`file-info-${type}`);
            
            if (fileInput && fileInfo) {
                fileInput.value = '';
                fileInfo.classList.add('hidden');
            }
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
    </script>
</body>
</html>
