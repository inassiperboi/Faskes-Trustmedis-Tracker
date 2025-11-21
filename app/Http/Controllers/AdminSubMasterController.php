<?php

namespace App\Http\Controllers;

use App\Models\SubMaster;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSubMasterController extends Controller
{
    public function index()
    {
        $submasters = SubMaster::with('master')->latest()->get();
        return view('admin.submaster.index', compact('submasters'));
    }

    public function create()
    {
        $masters = Master::all();
        return view('admin.submaster.create', compact('masters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'master_id' => 'required|exists:master,id',
            'nama' => 'required|string|max:255',
            'deadline' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('submaster_files', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->hashName();
            $data['file_original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        SubMaster::create($data);

        return redirect()->route('admin.submaster.index')
            ->with('success', 'Sub Master berhasil ditambahkan');
    }

    public function edit($id)
    {
        $submaster = SubMaster::findOrFail($id);
        $masters = Master::all();
        return view('admin.submaster.edit', compact('submaster', 'masters'));
    }

    public function update(Request $request, $id)
    {
        $submaster = SubMaster::findOrFail($id);

        $request->validate([
            'master_id' => 'required|exists:master,id',
            'nama' => 'required|string|max:255',
            'deadline' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
            'file' => 'nullable|file|max:10240',
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($submaster->file_path && Storage::disk('public')->exists($submaster->file_path)) {
                Storage::disk('public')->delete($submaster->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('submaster_files', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->hashName();
            $data['file_original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        $submaster->update($data);

        return redirect()->route('admin.submaster.index')
            ->with('success', 'Sub Master berhasil diperbarui');
    }

    public function destroy($id)
    {
        $submaster = SubMaster::findOrFail($id);
        
        if ($submaster->file_path && Storage::disk('public')->exists($submaster->file_path)) {
            Storage::disk('public')->delete($submaster->file_path);
        }
        
        $submaster->delete();

        return redirect()->route('admin.submaster.index')
            ->with('success', 'Sub Master berhasil dihapus');
    }
}
