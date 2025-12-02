<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Implementasi Faskes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            padding-bottom: 50px; /* BIKIN BAWAH GA NEPLEK */
        }

        .progress-bar {
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* New simple calendar styles */
        .calendar-day {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.75rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .calendar-day:hover:not(.today):not(.text-gray-300) {
            background-color: #f3f4f6;
        }
        .calendar-day.today {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
        }
        .calendar-day.has-event {
            position: relative;
        }
        .calendar-day.has-event::after {
            content: '';
            position: absolute;
            bottom: 2px;
            width: 4px;
            height: 4px;
            background-color: #10b981;
            border-radius: 50%;
        }
        .calendar-day.today.has-event::after {
            background-color: white;
        }

        /* ==== RESPONSIVE ==== */
        @media (max-width: 640px) {
            body {
                padding-bottom: 80px;
            }
            .calendar-day {
                width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }
        }
    </style>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }

        function addTeamMember(selectElement) {
            const value = selectElement.value;
            const text = selectElement.options[selectElement.selectedIndex].text;

            if (!value) return;

            // Check duplicates
            const inputs = document.querySelectorAll('input[name="tim[]"]');
            for(let input of inputs) {
                if(input.value === value) {
                    selectElement.value = "";
                    return;
                }
            }

            const uniqueId = 'team-' + Date.now() + Math.floor(Math.random() * 1000);

            // Create Tag
            const container = document.getElementById('selected-teams-container');
            const tag = document.createElement('div');
            tag.id = `tag-${uniqueId}`;
            tag.className = "bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full flex items-center mb-2 mr-2";
            tag.innerHTML = `
                <span>${text}</span>
                <button type="button" onclick="removeTeamMember('${uniqueId}')" class="ml-2 text-blue-600 hover:text-blue-800 focus:outline-none font-bold">
                    &times;
                </button>
            `;
            container.appendChild(tag);

            // Create Hidden Input
            const inputsContainer = document.getElementById('hidden-inputs-container');
            const input = document.createElement('input');
            input.type = "hidden";
            input.name = "tim[]";
            input.value = value;
            input.id = `input-${uniqueId}`;
            inputsContainer.appendChild(input);

            // Reset Select
            selectElement.value = "";
        }

        function removeTeamMember(uniqueId) {
            document.getElementById(`tag-${uniqueId}`).remove();
            document.getElementById(`input-${uniqueId}`).remove();
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
                    <h1 class="text-xl font-bold text-gray-800">Trustmedis Implementation Tracker</h1>
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
                                                <span class="font-medium">APO: <span class="text-gray-800">{{ $item->penanggung_jawab }}</span></span>
                                            </div>

                                            <div class="flex items-center">
                                                <i class="fas fa-users mr-3 text-gray-500"></i>
                                                <span class="font-medium">Data Migrator: <span class="text-gray-800">{{ $item->tim }}</span></span>
                                            </div>
                                        </div>

                                        <div class="mt-5">
                                            <!-- Ganti progress manual dengan perhitungan otomatis dari status submit sub_master dan sub_section -->
                                            <div class="flex justify-between text-sm mb-2">
                                                <span class="font-medium text-gray-700">Progress</span>
                                                <span class="font-semibold
                                                    @if($item->progress_percentage < 50) text-orange-600
                                                    @elseif($item->progress_percentage < 100) text-blue-600
                                                    @else text-green-600
                                                    @endif">
                                                    {{ number_format($item->progress_percentage, 1) }}%
                                                </span>
                                            </div>

                                            <div class="progress-bar">
                                                <div class="progress-fill
                                                    @if($item->progress_percentage < 50) bg-orange-500
                                                    @elseif($item->progress_percentage < 100) bg-blue-500
                                                    @else bg-green-500
                                                    @endif"
                                                    style="width: {{ $item->progress_percentage }}%">
                                                </div>
                                            </div>

                                            <!-- Tampilkan detail hitungan progress -->
                                            @php
                                                $totalItems = $item->getTotalProgressItems();
                                                $completedItems = $item->getCompletedProgressItems();
                                            @endphp
                                            <div class="mt-2 text-xs text-gray-500">
                                                <i class="fas fa-check-circle"></i>
                                                {{ $completedItems }} dari {{ $totalItems }} item selesai
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

            <!-- RIGHT: Calendar + Fitur Assessment -->
            <div class="md:col-span-1 space-y-6">

                <!-- New Simple Calendar Design -->
                <section class="bg-white rounded-lg shadow p-4 w-full">
                    <h2 class="text-lg font-semibold mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        Kalender Global
                    </h2>
                    
                    <div class="mb-4 flex justify-between items-center">
                        <button onclick="prevMonth()" class="p-1 rounded-full hover:bg-gray-100 transition">
                            <i class="fas fa-chevron-left text-gray-600"></i>
                        </button>
                        <span id="calendar-month-year" class="font-medium text-gray-800"></span>
                        <button onclick="nextMonth()" class="p-1 rounded-full hover:bg-gray-100 transition">
                            <i class="fas fa-chevron-right text-gray-600"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-7 gap-1 mb-2 text-center text-xs text-gray-500 font-medium">
                        <div>M</div><div>S</div><div>S</div><div>R</div><div>K</div><div>J</div><div>S</div>
                    </div>
                    
                    <div id="calendar-days" class="grid grid-cols-7 gap-1"></div>
                </section>

                <!-- Fitur Assessment -->
                <section class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-list-check text-blue-600 mr-2"></i>
                            Fitur Assessment
                        </h2>
                        <a href="{{ route('fitur.create') }}"
                           class="text-xs bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 transition duration-300 flex items-center">
                            <i class="fas fa-plus mr-1"></i>
                            Tambah Fitur
                        </a>
                    </div>

                    <div class="space-y-3 max-h-64 md:max-h-96 overflow-y-auto">
                        @forelse($fiturs as $fitur)
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 hover:bg-gray-100 transition duration-300">
                                <div class="text-xs font-semibold text-gray-700 mb-1">
                                    NO ASSESSMENT: {{ $fitur->no_assessment }}
                                </div>
                                <div class="text-sm font-medium text-gray-800 mb-2">
                                    {{ Str::limit($fitur->judul, 60) }}
                                </div>
                                <div class="text-xs text-gray-600 space-y-1">
                                    <div>
                                        <span class="font-medium">TARGET UAT:</span>
                                        {{ $fitur->target_uat ? $fitur->target_uat->format('d-m-Y') : '-' }}
                                    </div>
                                    <div>
                                        <span class="font-medium">TARGET RILIS:</span>
                                        {{ $fitur->target_due_date ? $fitur->target_due_date->format('d-m-Y') : '-' }}
                                    </div>
                                </div>
                                @if($fitur->link)
                                    <div class="mt-2">
                                        <a href="{{ $fitur->link }}" target="_blank"
                                           class="inline-block px-3 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition duration-300">
                                            LINK
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-gray-500 text-sm py-8">
                                <i class="fas fa-inbox text-3xl mb-2"></i>
                                <p>Belum ada data fitur</p>
                            </div>
                        @endforelse
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

                {{-- Updated Penanggung Jawab to Dropdown --}}
                <label class="block mb-2">APO (Penanggung Jawab)</label>
                <select name="penanggung_jawab" class="w-full border p-2 rounded mb-4" required>
                    <option value="">Pilih APO</option>
                    @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                {{-- Updated Tim to Custom Multi-Select UI --}}
                <label class="block mb-2">Tim</label>

                <!-- Container for selected tags -->
                <div id="selected-teams-container" class="flex flex-wrap mb-2"></div>

                <!-- Hidden inputs container -->
                <div id="hidden-inputs-container"></div>

                <!-- Dropdown to select -->
                <select id="team-selector" class="w-full border p-2 rounded mb-4" onchange="addTeamMember(this)">
                    <option value="">Pilih Anggota Tim</option>
                    @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                {{-- Changed Progress to Catatan --}}
                <label class="block mb-2">Catatan</label>
                <textarea name="catatan" placeholder="Tambahkan catatan..." class="w-full border p-2 rounded mb-4"></textarea>

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

    <script>
        // Simple Calendar Implementation
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        
        // Events from backend (will be populated via inline script or ajax)
        let calendarEvents = [];
        
        // Fetch events from backend
        async function fetchCalendarEvents() {
            try {
                const response = await fetch('{{ route("calendar.events") }}');
                calendarEvents = await response.json();
                renderCalendar();
            } catch (error) {
                console.error('Error fetching calendar events:', error);
                renderCalendar();
            }
        }
        
        function getMonthName(month) {
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return months[month];
        }
        
        function getDaysInMonth(month, year) {
            return new Date(year, month + 1, 0).getDate();
        }
        
        function getFirstDayOfMonth(month, year) {
            // Get day of week (0 = Sunday, 1 = Monday, etc.)
            // Convert to Monday-first (0 = Monday, 6 = Sunday)
            let day = new Date(year, month, 1).getDay();
            return day === 0 ? 6 : day - 1;
        }
        
        function hasEventOnDate(year, month, day) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            return calendarEvents.some(event => event.start && event.start.startsWith(dateStr));
        }
        
        function renderCalendar() {
            const monthYearEl = document.getElementById('calendar-month-year');
            const daysEl = document.getElementById('calendar-days');
            
            monthYearEl.textContent = `${getMonthName(currentMonth)} ${currentYear}`;
            
            const daysInMonth = getDaysInMonth(currentMonth, currentYear);
            const firstDay = getFirstDayOfMonth(currentMonth, currentYear);
            
            // Get days from previous month
            const prevMonth = currentMonth === 0 ? 11 : currentMonth - 1;
            const prevYear = currentMonth === 0 ? currentYear - 1 : currentYear;
            const daysInPrevMonth = getDaysInMonth(prevMonth, prevYear);
            
            let html = '';
            
            // Previous month days
            for (let i = firstDay - 1; i >= 0; i--) {
                const day = daysInPrevMonth - i;
                html += `<div class="calendar-day text-gray-300">${day}</div>`;
            }
            
            // Current month days
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = day === today.getDate() && 
                               currentMonth === today.getMonth() && 
                               currentYear === today.getFullYear();
                const hasEvent = hasEventOnDate(currentYear, currentMonth, day);
                
                let classes = 'calendar-day';
                if (isToday) classes += ' today';
                if (hasEvent) classes += ' has-event';
                
                html += `<div class="${classes}">${day}</div>`;
            }
            
            // Next month days to fill the grid
            const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
            const nextMonthDays = totalCells - (firstDay + daysInMonth);
            for (let day = 1; day <= nextMonthDays; day++) {
                html += `<div class="calendar-day text-gray-300">${day}</div>`;
            }
            
            daysEl.innerHTML = html;
        }
        
        function prevMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }
        
        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }
        
        // Initialize calendar on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchCalendarEvents();
        });
    </script>

</body>
</html>
