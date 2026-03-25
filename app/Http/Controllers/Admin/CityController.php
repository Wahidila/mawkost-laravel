<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount('kosts')->latest()->paginate(10);
        return view('admin.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string'
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $validated['kost_count'] = 0;
        City::create($validated);
        return back()->with('success', 'Kota berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $city = City::findOrFail($id);
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        $city = City::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($city->image && \Illuminate\Support\Str::startsWith($city->image, 'storage/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('storage/', '', $city->image));
            }
            $path = $request->file('image')->store('cities', 'public');
            $validated['image'] = 'storage/' . $path;
        }
        else {
            unset($validated['image']); // don't override existing if no new image uploaded
        }

        $city->update($validated);

        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        City::findOrFail($id)->delete();
        return back()->with('success', 'Kota berhasil dihapus.');
    }
}
