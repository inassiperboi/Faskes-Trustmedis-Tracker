<?php
// app/Http/Controllers/TahapanController.php
namespace App\Http\Controllers;

use App\Models\Faskes;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TahapanController extends Controller
{
    // FORM TAMBAH TAHAPAN
    public function create($faskes_id)
    {
        $faskes = Faskes::findOrFail($faskes_id);
        return view('tahapan.create', compact('faskes'));
    }

    // SIMPAN DATA TAHAPAN DENGAN FILE
    public function store(Request $request, $faskes_id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
            'progress' => 'nullable|integer|min:0|max:100',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar|max:10240', // 10MB
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
            $filePath = $file->storeAs('uploads/tahapan', $fileName, 'public');
            $fileSize = $this->formatFileSize($file->getSize());
        }

        Master::create([
            'faskes_id' => $faskes_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
            'progress' => $request->progress ?? 0,
            'completed' => $request->progress == 100 ? 1 : 0,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_original_name' => $fileOriginalName,
            'file_size' => $fileSize,
        ]);

        return redirect()->route('faskes.show', $faskes_id)
                         ->with('success', 'Tahapan berhasil ditambahkan!');
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