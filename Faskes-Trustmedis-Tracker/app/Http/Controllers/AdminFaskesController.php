<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\User;
use App\Models\MasterTahapan; // Import MasterTahapan
use App\Models\Master; // Import Master
use Illuminate\Http\Request;

class AdminFaskesController extends Controller
{
    public function index()
    {
        $faskes = Faskes::orderBy('created_at', 'desc')->get();
        return view('admin.faskes.index', compact('faskes'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.faskes.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'tim' => 'nullable|array',
            'catatan' => 'nullable|string',
        ]);

        $tim = $request->tim ? implode(', ', $request->tim) : null;

        $faskes = Faskes::create([
            'nama' => $request->nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'tim' => $tim,
            'catatan' => $request->catatan,
        ]);

        $masterTahapan = MasterTahapan::orderBy('urutan')->get();
        foreach ($masterTahapan as $tahapan) {
            Master::create([
                'faskes_id' => $faskes->id,
                'master_tahapan_id' => $tahapan->id,
                'nama' => $tahapan->nama,
                'deadline' => null,
                'catatan' => $tahapan->keterangan,
            ]);
        }

        return redirect()->route('admin.faskes.index')
            ->with('success', 'Faskes berhasil ditambahkan dan tahapan telah disalin dari Master Tahapan');
    }

    public function edit(Faskes $faske)
    {
        $users = User::where('role', 'user')->get();
        return view('admin.faskes.edit', compact('faske', 'users'));
    }

    public function update(Request $request, Faskes $faske)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'tim' => 'nullable|array',
            'catatan' => 'nullable|string',
        ]);

        $tim = $request->tim ? implode(', ', $request->tim) : null;

        $faske->update([
            'nama' => $request->nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'tim' => $tim,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.faskes.index')->with('success', 'Faskes berhasil diperbarui');
    }

    public function destroy(Faskes $faske)
    {
        $faske->delete();
        return redirect()->route('admin.faskes.index')->with('success', 'Faskes berhasil dihapus');
    }
}
