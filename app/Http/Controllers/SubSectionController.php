<?php

namespace App\Http\Controllers;

use App\Models\SubMaster;
use App\Models\SubSection;
use Illuminate\Http\Request;

class SubSectionController extends Controller
{
    // SIMPAN DATA SUB SECTION
    public function store(Request $request)
    {
        $request->validate([
            'sub_master_id' => 'required|exists:sub_master,id',
            'nama' => 'required|max:255',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        SubSection::create([
            'sub_master_id' => $request->sub_master_id,
            'nama' => $request->nama,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
            'progress' => $request->progress ?? 0,
            'completed' => $request->progress == 100 ? true : false,
        ]);

        return redirect()->back()->with('success', 'Sub-section berhasil ditambahkan!');
    }
}