<?php
// app/Http/Controllers/SubSectionController.php
namespace App\Http\Controllers;

use App\Models\SubMaster;
use App\Models\SubSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubSectionController extends Controller
{
    // SIMPAN DATA SUB SECTION DENGAN FILE
    public function store(Request $request)
    {
        $request->validate([
            'sub_master_id' => 'required|exists:sub_masters,id',
            'nama' => 'required|max:255',
            'deadline' => 'nullable|date',
            'catatan' => 'nullable',
            'progress' => 'nullable|integer|min:0|max:100',
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
            $filePath = $file->storeAs('uploads/subsection', $fileName, 'public');
            $fileSize = $this->formatFileSize($file->getSize());
        }

        SubSection::create([
            'sub_master_id' => $request->sub_master_id,
            'nama' => $request->nama,
            'deadline' => $request->deadline,
            'catatan' => $request->catatan,
            'progress' => $request->progress ?? 0,
            'completed' => $request->progress == 100 ? true : false,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_original_name' => $fileOriginalName,
            'file_size' => $fileSize,
        ]);

        return redirect()->back()->with('success', 'Sub-section berhasil ditambahkan!');
    }

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