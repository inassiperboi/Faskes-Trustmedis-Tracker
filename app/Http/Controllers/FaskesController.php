<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use Illuminate\Http\Request;

class FaskesController extends Controller
{
    // ====== TAMPILKAN DASHBOARD ======
    public function index()
    {
        $faskes = Faskes::orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('faskes'));
    }

    // ====== TAMPILKAN FORM TAMBAH ======
    public function create()
    {
        return view('faskes.create');
    }

    // ====== SIMPAN DATA FASKES ======
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'penanggung_jawab' => 'required|max:255',
            'tim' => 'nullable|string',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        Faskes::create([
            'nama' => $request->nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'tim' => $request->tim,
            'progress' => $request->progress ?? 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Faskes berhasil ditambahkan!');
    }

    // ====== DETAIL FASKES DINAMIS ======
    public function show($id)
    {
        $faskes = Faskes::with(['tahapan.subMasters'])->findOrFail($id);

        return view('detailfaskes', compact('faskes'));
    }
}
