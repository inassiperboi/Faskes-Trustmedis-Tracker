<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\Master;
use Illuminate\Http\Request;

class TahapanController extends Controller
{
    // FORM TAMBAH TAHAPAN
    public function create($faskes_id)
    {
        $faskes = Faskes::findOrFail($faskes_id);
        return view('tahapan.create', compact('faskes'));
    }

    // SIMPAN DATA TAHAPAN (VERSI SIMPLIFIED)
    public function store(Request $request, $faskes_id)
    {
        $request->validate([
            'nama' => 'required|max:255',      // Nama Tahapan
            'deadline' => 'nullable|date',     // Deadline
            'catatan' => 'nullable',           // Catatan
        ]);

        Master::create([
            'faskes_id' => $faskes_id,
            'nama' => $request->nama,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('faskes.show', $faskes_id)
                         ->with('success', 'Tahapan berhasil ditambahkan!');
    }

    // EDIT TAHAPAN
    public function edit($id)
    {
        $tahapan = Master::findOrFail($id);
        return view('tahapan.edit', compact('tahapan'));
    }

    // UPDATE TAHAPAN (VERSI SIMPLIFIED)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
        ]);

        $tahapan = Master::findOrFail($id);

        $tahapan->update([
            'nama' => $request->nama,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('faskes.show', $tahapan->faskes_id)
                         ->with('success', 'Tahapan berhasil diupdate!');
    }

    // HAPUS TAHAPAN
    public function destroy($id)
    {
        $tahapan = Master::findOrFail($id);
        $faskes_id = $tahapan->faskes_id;
        $tahapan->delete();

        return redirect()->route('faskes.show', $faskes_id)
                         ->with('success', 'Tahapan berhasil dihapus!');
    }
}