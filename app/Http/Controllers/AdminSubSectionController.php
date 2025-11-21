<?php

namespace App\Http\Controllers;

use App\Models\SubSection;
use App\Models\SubMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSubSectionController extends Controller
{
    public function index()
    {
        $subsections = SubSection::with('submaster')->latest()->get();
        return view('admin.subsection.index', compact('subsections'));
    }

    public function create()
    {
        $submasters = SubMaster::all();
        return view('admin.subsection.create', compact('submasters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_master_id' => 'required|exists:sub_master,id',
            'nama' => 'required|string|max:255',
            'deadline' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('subsection_files', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->hashName();
            $data['file_original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        SubSection::create($data);

        return redirect()->route('admin.subsection.index')
            ->with('success', 'Sub Section berhasil ditambahkan');
    }

    public function edit($id)
    {
        $subsection = SubSection::findOrFail($id);
        $submasters = SubMaster::all();
        return view('admin.subsection.edit', compact('subsection', 'submasters'));
    }

    public function update(Request $request, $id)
    {
        $subsection = SubSection::findOrFail($id);

        $request->validate([
            'sub_master_id' => 'required|exists:sub_master,id',
            'nama' => 'required|string|max:255',
            'deadline' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
            'file' => 'nullable|file|max:10240',
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($subsection->file_path && Storage::disk('public')->exists($subsection->file_path)) {
                Storage::disk('public')->delete($subsection->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('subsection_files', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->hashName();
            $data['file_original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        $subsection->update($data);

        return redirect()->route('admin.subsection.index')
            ->with('success', 'Sub Section berhasil diperbarui');
    }

    public function destroy($id)
    {
        $subsection = SubSection::findOrFail($id);
        
        if ($subsection->file_path && Storage::disk('public')->exists($subsection->file_path)) {
            Storage::disk('public')->delete($subsection->file_path);
        }
        
        $subsection->delete();

        return redirect()->route('admin.subsection.index')
            ->with('success', 'Sub Section berhasil dihapus');
    }
}
