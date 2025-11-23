<?php

namespace App\Http\Controllers;

use App\Models\MasterTahapan;
use Illuminate\Http\Request;

class AdminMasterTahapanController extends Controller
{
    public function index()
    {
        $masterTahapan = MasterTahapan::orderBy('urutan')->get();
        return view('admin.master-tahapan.index', compact('masterTahapan'));
    }

    public function create()
    {
        return view('admin.master-tahapan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'urutan' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        MasterTahapan::create($request->only(['nama', 'urutan', 'keterangan']));

        return redirect()->route('admin.master-tahapan.index')
            ->with('success', 'Master Tahapan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $masterTahapan = MasterTahapan::findOrFail($id);
        return view('admin.master-tahapan.edit', compact('masterTahapan'));
    }

    public function update(Request $request, $id)
    {
        $masterTahapan = MasterTahapan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'urutan' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $masterTahapan->update($request->only(['nama', 'urutan', 'keterangan']));

        return redirect()->route('admin.master-tahapan.index')
            ->with('success', 'Master Tahapan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $masterTahapan = MasterTahapan::findOrFail($id);
        $masterTahapan->delete();

        return redirect()->route('admin.master-tahapan.index')
            ->with('success', 'Master Tahapan berhasil dihapus');
    }
}
