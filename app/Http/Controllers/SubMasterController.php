<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\SubMaster;
use Illuminate\Http\Request;

class SubMasterController extends Controller
{
    // SIMPAN DATA SUB MASTER
    public function store(Request $request)
    {
        $request->validate([
            'master_id' => 'required|exists:master,id', // Ganti 'masters' menjadi 'master'
            'nama' => 'required|max:255',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        SubMaster::create([
            'master_id' => $request->master_id,
            'nama' => $request->nama,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
            'progress' => $request->progress ?? 0,
            'completed' => $request->progress == 100 ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Sub tahapan berhasil ditambahkan!');
    }
}