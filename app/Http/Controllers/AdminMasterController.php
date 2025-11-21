<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Faskes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMasterController extends Controller
{
    public function index()
    {
        $masters = Master::with('faskes')->latest()->get();
        return view('admin.master.index', compact('masters'));
    }

    public function create()
    {
        $faskes = Faskes::all();
        return view('admin.master.create', compact('faskes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'faskes_id' => 'required|exists:faskes,id',
            'nama' => 'required|string|max:255',
            'deadline' => 'required|date',
            'catatan' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $data = $request->only(['faskes_id', 'nama', 'deadline', 'catatan']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/masters', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->hashName();
            $data['file_original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        Master::create($data);

        return redirect()->route('admin.master.index')->with('success', 'Data Master berhasil ditambahkan');
    }

    public function edit($id)
    {
        $master = Master::findOrFail($id);
        $faskes = Faskes::all();
        return view('admin.master.edit', compact('master', 'faskes'));
    }

    public function update(Request $request, $id)
    {
        $master = Master::findOrFail($id);

        $request->validate([
            'faskes_id' => 'required|exists:faskes,id',
            'nama' => 'required|string|max:255',
            'deadline' => 'required|date',
            'catatan' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $data = $request->only(['faskes_id', 'nama', 'deadline', 'catatan']);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($master->file_path && Storage::disk('public')->exists($master->file_path)) {
                Storage::disk('public')->delete($master->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('uploads/masters', 'public');
            
            $data['file_path'] = $path;
            $data['file_name'] = $file->hashName();
            $data['file_original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        $master->update($data);

        return redirect()->route('admin.master.index')->with('success', 'Data Master berhasil diperbarui');
    }

    public function destroy($id)
    {
        $master = Master::findOrFail($id);
        
        if ($master->file_path && Storage::disk('public')->exists($master->file_path)) {
            Storage::disk('public')->delete($master->file_path);
        }
        
        $master->delete();

        return redirect()->route('admin.master.index')->with('success', 'Data Master berhasil dihapus');
    }
}
