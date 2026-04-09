<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KostType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KostTypeController extends Controller
{
    public function index()
    {
        $kostTypes = KostType::withCount('kosts')->latest()->paginate(10);
        return view('admin.kost_types.index', compact('kostTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        KostType::create($validated);

        return back()->with('success', 'Tipe Kost berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kostType = KostType::findOrFail($id);
        return view('admin.kost_types.edit', compact('kostType'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        $kostType = KostType::findOrFail($id);
        $kostType->update($validated);

        return redirect()->route('admin.kost_types.index')->with('success', 'Tipe Kost berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        KostType::findOrFail($id)->delete();
        return back()->with('success', 'Tipe Kost berhasil dihapus.');
    }
}
