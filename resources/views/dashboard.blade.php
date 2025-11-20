<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Implementasi Faskes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    
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
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Styles untuk kalender mini di dashboard - diperbaiki untuk tampilan lebih bagus */
        #calendar-mini {
            font-size: 0.85rem; /* Sedikit diperbesar dari 0.75rem */
            font-family: 'Inter', sans-serif; /* Font yang lebih modern */
        }
        #calendar-mini .fc-header-toolbar {
            margin-bottom: 0.75em;
            font-size: 0.9rem; /* Diperbesar */
            background: linear-gradient(135deg, #3b82f6, #1e40af); /* Gradient biru untuk header */
            color: white;
            border-radius: 8px;
            padding: 0.5em;
        }
        #calendar-mini .fc-toolbar-title {
            font-size: 1rem; /* Diperbesar */
            font-weight: bold;
        }
        #calendar-mini .fc-button {
            padding: 0.3em 0.6em; /* Diperbesar */
            font-size: 0.8rem; /* Diperbesar */
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
            min-height: 2.5rem; /* Diperbesar untuk lebih nyaman */
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        #calendar-mini .fc-daygrid-day:hover {
            background: #f0f9ff; /* Hover effect */
        }
        #calendar-mini .fc-daygrid-day-number {
            font-size: 0.8rem; /* Diperbesar */
            padding: 4px;
            font-weight: 600;
        }
        #calendar-mini .fc-event {
            font-size: 0.7rem; /* Diperbesar sedikit */
            padding: 2px 4px; /* Diperbesar */
            margin: 2px 0;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        #calendar-mini .fc-event:hover {
            transform: scale(1.05); /* Sedikit zoom on hover */
        }
        #calendar-mini .fc-day-today {
            background: #dbeafe !important; /* Highlight hari ini */
            border: 2px solid #3b82f6;
        }
        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 0.5rem;
            font-size: 0.8rem; /* Diperbesar */
        }
        .legend-color {
            width: 12px; /* Diperbesar */
            height: 12px; /* Diperbesar */
            border-radius: 3px;
            margin-right: 0.4rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
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

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar-mini');
            
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
                dayMaxEvents: 2, // Limit events per day untuk tampilan mini
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                }
            });
            
            calendar.render();
        });
    </script>

</body>
</html>
