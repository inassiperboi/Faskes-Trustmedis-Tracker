<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\User; // Import User model
use Illuminate\Http\Request;

class FaskesController extends Controller
{
    // ====== TAMPILKAN DASHBOARD ======
    public function index()
    {
        $faskes = Faskes::orderBy('created_at', 'desc')->get();
        $users = User::where('role', 'user')->get();
        return view('user.dashboard', compact('faskes', 'users'));
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
            'tim' => 'nullable|array', // Validate as array
            'catatan' => 'nullable|string', // Validate catatan instead of progress
        ]);

        Faskes::create([
            'nama' => $request->nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'tim' => $request->tim ? implode(', ', $request->tim) : null, // Convert array to string
            'catatan' => $request->catatan, // Save catatan
        ]);

        return redirect()->route('dashboard')->with('success', 'Faskes berhasil ditambahkan!');
    }

    // ====== DETAIL FASKES DINAMIS ======
    public function show($id)
    {
        $faskes = Faskes::with(['tahapan.subMasters'])->findOrFail($id);

        return view('user.detailfaskes', compact('faskes'));
    }
}
