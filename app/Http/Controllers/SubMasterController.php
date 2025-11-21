<?php
// app/Http/Controllers/SubMasterController.php
namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\SubMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubMasterController extends Controller
{
    // SIMPAN DATA SUB MASTER DENGAN FILE
    public function store(Request $request)
    {
        $request->validate([
            'master_id' => 'required|exists:master,id',
            'nama' => 'required|max:255',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar|max:10240',
        ]);

        $filePath = null;
        $fileName = null;
        $fileOriginalName = null;
        $fileSize = null;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileOriginalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '_' . $fileOriginalName;
            $filePath = $file->storeAs('uploads/submaster', $fileName, 'public');
            $fileSize = $this->formatFileSize($file->getSize());
        }

        SubMaster::create([
            'master_id' => $request->master_id,
            'nama' => $request->nama,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
            'status' => 'pending', // Ganti dengan status default
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_original_name' => $fileOriginalName,
            'file_size' => $fileSize,
        ]);

        return redirect()->back()->with('success', 'Sub tahapan berhasil ditambahkan!');
    }

    // EDIT SUB MASTER
    public function edit($id)
    {
        $submaster = SubMaster::findOrFail($id);
        return view('submaster.edit', compact('submaster'));
    }

    // UPDATE SUB MASTER
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar|max:10240',
        ]);

        $submaster = SubMaster::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
            // Status tidak diupdate dari form, hanya dari tombol submit
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($submaster->file_path && Storage::disk('public')->exists($submaster->file_path)) {
                Storage::disk('public')->delete($submaster->file_path);
            }

            $file = $request->file('file');
            $fileOriginalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '_' . $fileOriginalName;
            $filePath = $file->storeAs('uploads/submaster', $fileName, 'public');
            $fileSize = $this->formatFileSize($file->getSize());

            $data['file_path'] = $filePath;
            $data['file_name'] = $fileName;
            $data['file_original_name'] = $fileOriginalName;
            $data['file_size'] = $fileSize;
        }

        $submaster->update($data);

        return redirect()->back()->with('success', 'Sub Master berhasil diupdate!');
    }

    // MARK AS COMPLETED - Fungsi baru untuk tombol submit
    public function markAsCompleted($id)
    {
        $submaster = SubMaster::findOrFail($id);
        $submaster->markAsCompleted();

        return redirect()->back()->with('success', 'Sub Master telah ditandai sebagai selesai!');
    }

    // MARK AS PENDING - Fungsi baru untuk reset status
    public function markAsPending($id)
    {
        $submaster = SubMaster::findOrFail($id);
        $submaster->markAsPending();

        return redirect()->back()->with('success', 'Sub Master telah ditandai sebagai pending!');
    }

    // HAPUS SUB MASTER
    public function destroy($id)
    {
        $submaster = SubMaster::findOrFail($id);

        // Hapus file jika ada
        if ($submaster->file_path && Storage::disk('public')->exists($submaster->file_path)) {
            Storage::disk('public')->delete($submaster->file_path);
        }

        $submaster->delete();

        return redirect()->back()->with('success', 'Sub Master berhasil dihapus!');
    }

    // Helper function untuk format file size
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}