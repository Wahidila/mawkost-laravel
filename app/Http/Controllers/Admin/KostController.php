<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Facility;
use App\Models\Kost;
use App\Models\KostType;
use App\Models\KostImage;
use App\Models\NearbyPlace;
use App\Services\WatermarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    public function index(Request $request)
    {
        $query = Kost::with('city')->latest();

        if ($request->filter === 'featured') {
            $query->where('is_featured', true);
        } elseif ($request->filter === 'recommended') {
            $query->where('is_recommended', true);
        }

        $kosts = $query->paginate(10)->withQueryString();
        $currentFilter = $request->filter;

        return view('admin.kosts.index', compact('kosts', 'currentFilter'));
    }

    public function create()
    {
        $cities = City::all();
        $facilities = Facility::all();
        $kostTypes = KostType::all();
        return view('admin.kosts.create', compact('cities', 'facilities', 'kostTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'kost_type_id' => 'required|exists:kost_types,id',
            'price' => 'required|integer',
            'description' => 'required|string',
            'area_label' => 'required|string|max:255',
            'total_rooms' => 'required|integer',
            'total_bathrooms' => 'nullable|integer',
            'floor_count' => 'nullable|string',
            'parking_type' => 'nullable|string',
            'unlock_price' => 'required|integer',
            'address' => 'required|string',
            'owner_contact' => 'required|string',
            'owner_name' => 'nullable|string',
            'maps_link' => 'nullable|string',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'nearby_places' => 'nullable|string',
        ]);

        $lastKost = Kost::orderBy('id', 'desc')->first();
        $lastId = $lastKost ? $lastKost->id + 1 : 1;
        $validated['kode'] = 'MK-' . str_pad($lastId, 3, '0', STR_PAD_LEFT);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        // Sync 'type' column with the selected KostType slug
        $kostType = KostType::find($validated['kost_type_id']);
        $validated['type'] = $kostType ? $kostType->slug : 'campur';

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_recommended'] = $request->has('is_recommended');
        $validated['purchase_count'] = 0;

        $kost = Kost::create($validated);

        // Sync Facilities
        if ($request->has('facilities')) {
            $kost->facilities()->sync($request->facilities);
        }

        // Process Images
        if ($request->hasFile('images')) {
            $watermarkService = app(WatermarkService::class);
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('kosts', 'public');

                // Apply watermark if enabled
                $watermarkService->apply($path);

                KostImage::create([
                    'kost_id' => $kost->id,
                    'image_path' => 'storage/' . $path,
                    'sort_order' => $i
                ]);
            }
        }

        // Process Nearby Places
        if (!empty($validated['nearby_places'])) {
            $places = explode("\n", str_replace("\r", "", $validated['nearby_places']));
            foreach ($places as $i => $place) {
                if (trim($place) != '') {
                    NearbyPlace::create([
                        'kost_id' => $kost->id,
                        'description' => trim($place),
                        'sort_order' => $i
                    ]);
                }
            }
        }

        return redirect()->route('admin.kosts.index')->with('success', 'Kost berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kost = Kost::with(['facilities', 'images', 'nearbyPlaces'])->findOrFail($id);
        $cities = City::all();
        $facilities = Facility::all();
        $kostTypes = KostType::all();

        $nearbyPlacesStr = $kost->nearbyPlaces->pluck('description')->join("\n");

        return view('admin.kosts.edit', compact('kost', 'cities', 'facilities', 'kostTypes', 'nearbyPlacesStr'));
    }

    public function update(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'required|unique:kosts,kode,' . $kost->id,
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'kost_type_id' => 'required|exists:kost_types,id',
            'price' => 'required|integer',
            'description' => 'required|string',
            'area_label' => 'required|string|max:255',
            'total_rooms' => 'required|integer',
            'total_bathrooms' => 'nullable|integer',
            'floor_count' => 'nullable|string',
            'parking_type' => 'nullable|string',
            'unlock_price' => 'required|integer',
            'address' => 'required|string',
            'owner_contact' => 'required|string',
            'owner_name' => 'nullable|string',
            'maps_link' => 'nullable|string',
            'facilities' => 'array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'nearby_places' => 'nullable|string',
        ]);

        if ($request->title != $kost->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        // Sync 'type' column with the selected KostType slug
        $kostType = KostType::find($validated['kost_type_id']);
        $validated['type'] = $kostType ? $kostType->slug : 'campur';

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_recommended'] = $request->has('is_recommended');

        $kost->update($validated);

        if ($request->has('facilities')) {
            $kost->facilities()->sync($request->facilities);
        }
        else {
            $kost->facilities()->sync([]);
        }

        // Process Additional Images
        if ($request->hasFile('images')) {
            $watermarkService = app(WatermarkService::class);
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('kosts', 'public');

                // Apply watermark if enabled
                $watermarkService->apply($path);

                KostImage::create([
                    'kost_id' => $kost->id,
                    'image_path' => 'storage/' . $path,
                    'sort_order' => $kost->images()->count() + $i
                ]);
            }
        }

        // Update logic for Nearby Places
        $kost->nearbyPlaces()->delete();
        if (!empty($validated['nearby_places'])) {
            $places = explode("\n", str_replace("\r", "", $validated['nearby_places']));
            foreach ($places as $i => $place) {
                if (trim($place) != '') {
                    NearbyPlace::create([
                        'kost_id' => $kost->id,
                        'description' => trim($place),
                        'sort_order' => $i
                    ]);
                }
            }
        }

        return redirect()->route('admin.kosts.index')->with('success', 'Kost berhasil diupdate');
    }

    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);

        // Remove images from storage if needed (ignoring seed assets)
        foreach ($kost->images as $img) {
            if (Str::startsWith($img->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $img->image_path));
            }
            $img->delete();
        }

        $kost->delete();

        return redirect()->route('admin.kosts.index')->with('success', 'Kost berhasil dihapus');
    }

    public function toggleFeatured($id)
    {
        $kost = Kost::findOrFail($id);
        $kost->update(['is_featured' => !$kost->is_featured]);

        $status = $kost->is_featured ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Featured {$status} untuk {$kost->title}");
    }

    public function toggleRecommended($id)
    {
        $kost = Kost::findOrFail($id);
        $kost->update(['is_recommended' => !$kost->is_recommended]);

        $status = $kost->is_recommended ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Rekomendasi {$status} untuk {$kost->title}");
    }

    // Custom method to delete single image via ajax/form
    public function destroyImage($kost, $image)
    {
        $image = KostImage::where('kost_id', $kost)->findOrFail($image);
        if (Str::startsWith($image->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
        }
        $image->delete();
        return back()->with('success', 'Gambar berhasil dihapus');
    }
}
