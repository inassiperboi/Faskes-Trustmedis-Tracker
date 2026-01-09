<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Global - Trustmedis Implementation Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <style>
        body {
            padding-bottom: 50px;
        }

        .fc-event {
            cursor: pointer;
        }

        .fc-event:hover {
            opacity: 0.8;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 1rem;
            font-size: 0.9rem;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            margin-right: 0.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .reminder-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .deadline-warning {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .deadline-warning .warning-icon {
            color: #f59e0b;
            font-size: 1.5rem;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <i class="fas fa-calendar-alt text-2xl text-blue-600 mr-3"></i>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Kalender Global</h1>
                    <p class="text-sm text-gray-600">Pantau semua deadline implementasi faskes</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    <i class="fas fa-user-circle mr-1"></i>
                    <span>{{ Auth::user()->name ?? 'User' }}</span>
                </div>

                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>

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

    <!-- Container -->
    <div class="container mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- Main Calendar -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow p-6 fade-in">

                    <!-- Legend -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Legenda
                        </h3>
                        <div class="flex flex-wrap gap-4">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #3b82f6;"></div>
                                <span>Tahapan Implementasi</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #10b981;"></div>
                                <span>Sub-Master</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #8b5cf6;"></div>
                                <span>Sub-Section</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #0ea5e9;"></div>
                                <span>Fitur Target UAT</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #f59e0b;"></div>
                                <span>Fitur Target Rilis</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #ef4444;"></div>
                                <span>Deadline Mendekati (< 3 hari)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deadline Warnings -->
                    @php
                        $upcomingDeadlines = collect($events)->filter(function($event) {
                            $eventDate = new DateTime($event['start']);
                            $today = new DateTime();
                            $diff = $today->diff($eventDate);
                            return $diff->days <= 3 && $diff->invert == 0; // Upcoming, not past
                        })->sortBy('start')->take(5);
                    @endphp

                    @if($upcomingDeadlines->count() > 0)
                    <div class="deadline-warning mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle warning-icon mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Pengingat Deadline Mendekati</h4>
                                <div class="space-y-1">
                                    @foreach($upcomingDeadlines as $deadline)
                                        @php
                                            $eventDate = new DateTime($deadline['start']);
                                            $today = new DateTime();
                                            $diff = $today->diff($eventDate);
                                            $daysLeft = $diff->days;
                                        @endphp
                                        <div class="text-sm text-gray-700">
                                            <strong>{{ $deadline['title'] }}</strong> -
                                            {{ $daysLeft == 0 ? 'Hari ini' : ($daysLeft == 1 ? 'Besok' : $daysLeft . ' hari lagi') }}
                                            ({{ $eventDate->format('d/m/Y') }})
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Calendar -->
                    <div id="calendar-global"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                        Statistik
                    </h3>

                    @php
                        $totalEvents = count($events);
                        $upcomingCount = collect($events)->filter(function($event) {
                            $eventDate = new DateTime($event['start']);
                            $today = new DateTime();
                            return $eventDate >= $today;
                        })->count();

                        $overdueCount = collect($events)->filter(function($event) {
                            $eventDate = new DateTime($event['start']);
                            $today = new DateTime();
                            return $eventDate < $today;
                        })->count();
                    @endphp

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Deadline</span>
                            <span class="font-semibold text-blue-600">{{ $totalEvents }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Mendekati</span>
                            <span class="font-semibold text-orange-600">{{ $upcomingCount }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Terlewat</span>
                            <span class="font-semibold text-red-600">{{ $overdueCount }}</span>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Deadlines -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-clock text-blue-600 mr-2"></i>
                        Deadline Mendekati
                    </h3>

                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($upcomingDeadlines as $deadline)
                            @php
                                $eventDate = new DateTime($deadline['start']);
                                $today = new DateTime();
                                $diff = $today->diff($eventDate);
                                $daysLeft = $diff->days;
                            @endphp

                            <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition duration-300 cursor-pointer"
                                 onclick="window.location.href='{{ $deadline['url'] }}'">
                                <div class="text-xs font-semibold text-gray-700 mb-1">
                                    {{ $deadline['faskes'] }}
                                </div>
                                <div class="text-sm font-medium text-gray-800 mb-1">
                                    {{ $deadline['title'] }}
                                </div>
                                <div class="text-xs text-gray-600">
                                    <i class="fas fa-calendar-day mr-1"></i>
                                    {{ $eventDate->format('d/m/Y') }}
                                    <span class="ml-2 font-medium
                                        {{ $daysLeft == 0 ? 'text-red-600' : ($daysLeft <= 1 ? 'text-orange-600' : 'text-blue-600') }}">
                                        ({{ $daysLeft == 0 ? 'Hari ini' : ($daysLeft == 1 ? 'Besok' : $daysLeft . ' hari') }})
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 text-sm py-4">
                                <i class="fas fa-check-circle text-green-500 text-2xl mb-2"></i>
                                <p>Tidak ada deadline mendekati</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar-global');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
                events: {{ json_encode($events) }},
                displayEventTime: false,
                eventClick: function(info) {
                    // Prevent default behavior
                    info.jsEvent.preventDefault();

                    if (info.event.url) {
                        // Show confirmation dialog
                        if (confirm('Lihat detail deadline: ' + info.event.title + '?\n\nFaskes: ' + info.event.extendedProps.faskes)) {
                            window.location.href = info.event.url;
                        }
                    }
                },
                eventDidMount: function(info) {
                    // Add tooltip
                    info.el.title = info.event.title + '\nFaskes: ' + info.event.extendedProps.faskes + '\nTipe: ' + info.event.extendedProps.type;

                    // Highlight upcoming deadlines
                    const eventDate = new Date(info.event.start);
                    const today = new Date();
                    const diffTime = eventDate - today;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (diffDays < 0) {
                        // Overdue - red with strikethrough
                        info.el.style.backgroundColor = '#dc2626';
                        info.el.style.borderColor = '#dc2626';
                        info.el.style.color = 'white';
                        info.el.style.textDecoration = 'line-through';
                        info.el.style.opacity = '0.7';
                    } else if (diffDays <= 3) {
                        // Upcoming - red background
                        info.el.style.backgroundColor = '#ef4444';
                        info.el.style.borderColor = '#ef4444';
                        info.el.style.color = 'white';
                        info.el.style.fontWeight = 'bold';

                        // Add reminder badge
                        const badge = document.createElement('div');
                        badge.className = 'reminder-badge';
                        badge.innerHTML = '!';
                        info.el.style.position = 'relative';
                        info.el.appendChild(badge);
                    } else if (diffDays <= 7) {
                        // Warning - orange
                        info.el.style.backgroundColor = '#f97316';
                        info.el.style.borderColor = '#f97316';
                        info.el.style.color = 'white';
                    }
                },
                eventMouseEnter: function(info) {
                    info.el.style.transform = 'scale(1.05)';
                    info.el.style.zIndex = '10';
                },
                eventMouseLeave: function(info) {
                    info.el.style.transform = 'scale(1)';
                    info.el.style.zIndex = 'auto';
                },
                dayMaxEvents: 3,
                moreLinkClick: 'popover',
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                }
            });

            calendar.render();
        });
    </script>

</body>
</html>
