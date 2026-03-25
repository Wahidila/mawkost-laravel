<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::latest()->paginate(10);
        return view('admin.facilities.index', compact('facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
            'category' => 'required|in:kamar,bersama'
        ]);
        $facility = Facility::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'facility' => $facility
            ]);
        }

        return back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
    //
    }

    public function destroy(string $id)
    {
        Facility::findOrFail($id)->delete();
        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }
}
