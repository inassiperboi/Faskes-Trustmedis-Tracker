<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\Master;
use App\Models\SubMaster;
use App\Models\SubSection;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = $this->getAllDeadlines();
        return view('calendar.global', compact('events'));
    }

    public function apiEvents()
    {
        $events = $this->getAllDeadlines();
        return response()->json($events);
    }

    private function getAllDeadlines()
    {
        $events = [];

        // Ambil dari Master (Tahapan)
        $masterDeadlines = Master::whereNotNull('deadline')
            ->with('faskes')
            ->get()
            ->map(function ($master) {
                return [
                    'id' => 'master_' . $master->id,
                    'title' => '📋 ' . $master->nama,
                    'start' => $master->deadline,
                    'color' => '#3b82f6',
                    'type' => 'tahapan',
                    'faskes' => $master->faskes->nama,
                    'url' => route('faskes.show', $master->faskes_id)
                ];
            });

        // Ambil dari SubMaster
        $subMasterDeadlines = SubMaster::whereNotNull('deadline')
            ->with(['master.faskes'])
            ->get()
            ->map(function ($subMaster) {
                return [
                    'id' => 'submaster_' . $subMaster->id,
                    'title' => '🔹 ' . $subMaster->nama,
                    'start' => $subMaster->deadline,
                    'color' => '#10b981',
                    'type' => 'submaster',
                    'faskes' => $subMaster->master->faskes->nama,
                    'url' => route('faskes.show', $subMaster->master->faskes_id)
                ];
            });

        // Ambil dari SubSection
        $subSectionDeadlines = SubSection::whereNotNull('deadline')
            ->with(['submaster.master.faskes'])
            ->get()
            ->map(function ($subSection) {
                return [
                    'id' => 'subsection_' . $subSection->id,
                    'title' => '⚪ ' . $subSection->nama,
                    'start' => $subSection->deadline,
                    'color' => '#8b5cf6',
                    'type' => 'subsection',
                    'faskes' => $subSection->submaster->master->faskes->nama,
                    'url' => route('faskes.show', $subSection->submaster->master->faskes_id)
                ];
            });

        // Gabungkan semua events
        return $masterDeadlines->merge($subMasterDeadlines)->merge($subSectionDeadlines);
    }
}
