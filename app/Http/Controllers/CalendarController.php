<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\Fitur;
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
            })
            ->values();

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
            })
            ->values();

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
            })
            ->values();

        // Ambil dari Fitur Assessment - Target UAT
        $fiturUatDeadlines = Fitur::whereNotNull('target_uat')
            ->get()
            ->map(function ($fitur) {
                return [
                    'id' => 'fitur_uat_' . $fitur->id,
                    'title' => '🧪 UAT - ' . $fitur->judul,
                    'start' => $fitur->target_uat,
                    'color' => '#0ea5e9',
                    'type' => 'fitur_uat',
                    'faskes' => 'Fitur Assessment ' . $fitur->no_assessment,
                    'url' => $fitur->link ?? route('fitur.index')
                ];
            })
            ->values();

        // Ambil dari Fitur Assessment - Target Rilis
        $fiturRilisDeadlines = Fitur::whereNotNull('target_due_date')
            ->get()
            ->map(function ($fitur) {
                return [
                    'id' => 'fitur_rilis_' . $fitur->id,
                    'title' => '🚀 Rilis - ' . $fitur->judul,
                    'start' => $fitur->target_due_date,
                    'color' => '#f59e0b',
                    'type' => 'fitur_rilis',
                    'faskes' => 'Fitur Assessment ' . $fitur->no_assessment,
                    'url' => $fitur->link ?? route('fitur.index')
                ];
            })
            ->values();

        // Gabungkan semua events
        return $masterDeadlines
            ->concat($subMasterDeadlines)
            ->concat($subSectionDeadlines)
            ->concat($fiturUatDeadlines)
            ->concat($fiturRilisDeadlines);
    }
}
