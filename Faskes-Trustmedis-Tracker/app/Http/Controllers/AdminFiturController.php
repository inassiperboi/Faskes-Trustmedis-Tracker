<?php

namespace App\Http\Controllers;

use App\Models\Fitur;
use Illuminate\Http\Request;

class AdminFiturController extends Controller
{
    public function index()
    {
        $fiturs = Fitur::latest()->get();
        return view('admin.fitur.index', compact('fiturs'));
    }

    public function create()
    {
        return view('admin.fitur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_assessment' => 'required|string|max:255',
            'judul' => 'required|string',
            'target_uat' => 'required|date',
            'target_due_date' => 'required|date',
            'link' => 'nullable|url|max:255',
        ]);

        Fitur::create($request->all());

        return redirect()->route('admin.fitur.index')->with('success', 'Data Fitur berhasil ditambahkan');
    }

    public function edit($id)
    {
        $fitur = Fitur::findOrFail($id);
        return view('admin.fitur.edit', compact('fitur'));
    }

    public function update(Request $request, $id)
    {
        $fitur = Fitur::findOrFail($id);

        $request->validate([
            'no_assessment' => 'required|string|max:255',
            'judul' => 'required|string',
            'target_uat' => 'required|date',
            'target_due_date' => 'required|date',
            'link' => 'nullable|url|max:255',
        ]);

        $fitur->update($request->all());

        return redirect()->route('admin.fitur.index')->with('success', 'Data Fitur berhasil diperbarui');
    }

    public function destroy($id)
    {
        $fitur = Fitur::findOrFail($id);
        $fitur->delete();

        return redirect()->route('admin.fitur.index')->with('success', 'Data Fitur berhasil dihapus');
    }
}
