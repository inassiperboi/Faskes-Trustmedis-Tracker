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

    // SIMPAN DATA TAHAPAN
    public function store(Request $request, $faskes_id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        Master::create([
            'faskes_id' => $faskes_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
            'progress' => $request->progress ?? 0,
            'completed' => $request->progress == 100 ? 1 : 0,
        ]);

        return redirect()->route('faskes.show', $faskes_id)
                         ->with('success', 'Tahapan berhasil ditambahkan!');
    }
}
