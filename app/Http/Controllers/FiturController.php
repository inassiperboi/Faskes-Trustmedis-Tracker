<?php

namespace App\Http\Controllers;

use App\Models\Fitur;
use Illuminate\Http\Request;

class FiturController extends Controller
{
    public function index()
    {
        $fiturs = Fitur::orderBy('created_at', 'desc')->get();
        return view('user.fitur.index', compact('fiturs'));
    }

    public function create()
    {
        return view('user.fitur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_assessment' => 'required|unique:fitur,no_assessment',
            'judul' => 'required',
            'target_uat' => 'nullable|date',
            'target_due_date' => 'nullable|date',
            'link' => 'nullable|url',
        ]);

        Fitur::create($validated);

        return redirect()->route('dashboard')->with('success', 'Fitur berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $fitur = Fitur::findOrFail($id);
        return view('user.fitur.edit', compact('fitur'));
    }

    public function update(Request $request, $id)
    {
        $fitur = Fitur::findOrFail($id);

        $validated = $request->validate([
            'no_assessment' => 'required|unique:fitur,no_assessment,' . $id,
            'judul' => 'required',
            'target_uat' => 'nullable|date',
            'target_due_date' => 'nullable|date',
            'link' => 'nullable|url',
        ]);

        $fitur->update($validated);

        return redirect()->route('dashboard')->with('success', 'Fitur berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $fitur = Fitur::findOrFail($id);
        $fitur->delete();

        return redirect()->route('dashboard')->with('success', 'Fitur berhasil dihapus!');
    }
}
