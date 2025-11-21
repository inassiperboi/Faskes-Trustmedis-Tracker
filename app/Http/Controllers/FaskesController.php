<?php

namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\User; // Import User model
use App\Models\MasterTahapan; // Import MasterTahapan model
use App\Models\Master; // Import Master model
use App\Models\Fitur; // Added Fitur model import
use Illuminate\Http\Request;

class FaskesController extends Controller
{
    // ====== TAMPILKAN DASHBOARD ======
    public function index()
    {
        $faskes = Faskes::orderBy('created_at', 'desc')->get();
        $users = User::where('role', 'user')->get();
        $fiturs = Fitur::orderBy('created_at', 'desc')->get(); // Added $fiturs variable to pass to the view
        return view('user.dashboard', compact('faskes', 'users', 'fiturs'));
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

        $faskes = Faskes::create([
            'nama' => $request->nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'tim' => $request->tim ? implode(', ', $request->tim) : null, // Convert array to string
            'catatan' => $request->catatan, // Save catatan
        ]);

        $masterTahapans = MasterTahapan::orderBy('urutan', 'asc')->get();

        foreach ($masterTahapans as $mt) {
            Master::create([
                'faskes_id' => $faskes->id,
                'master_tahapan_id' => $mt->id,
                'nama' => $mt->nama,
                'catatan' => $mt->keterangan,
                'deadline' => null, // Deadline diisi manual nanti
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Faskes berhasil ditambahkan!');
    }

    // ====== DETAIL FASKES DINAMIS ======
    public function show($id)
    {
        $faskes = Faskes::with(['tahapan.subMasters'])->findOrFail($id);
        $fiturs = Fitur::orderBy('created_at', 'desc')->get();

        return view('user.detailfaskes', compact('faskes', 'fiturs'));
    }
}
