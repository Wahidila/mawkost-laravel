<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Kost;
use App\Models\KostType;
use Illuminate\Http\Request;

class KostController extends Controller
{
    public function search(Request $request)
    {
        $query = Kost::with('city', 'images', 'facilities', 'kostType');

        if ($request->filled('lokasi')) {
            $city = City::where('slug', $request->lokasi)->first();
            if ($city) {
                $query->where('city_id', $city->id);
            }
        }

        if ($request->filled('tipe')) {
            $type = KostType::where('slug', $request->tipe)->first();
            if ($type) {
                $query->where('kost_type_id', $type->id);
            }
            else {
                $query->where('type', $request->tipe);
            }
        }

        if ($request->filled('min_harga')) {
            $query->where('price', '>=', $request->min_harga);
        }

        if ($request->filled('max_harga')) {
            $query->where('price', '<=', $request->max_harga);
        }

        // Featured kost muncul duluan di listing
        $query->orderByDesc('is_featured')->orderByDesc('is_recommended')->latest();

        $kosts = $query->paginate(9)->withQueryString();
        $cities = City::orderBy('name')->get();
        $kostTypes = KostType::orderBy('name')->get();

        return view('kost.search', compact('kosts', 'cities', 'kostTypes'));
    }

    public function byCity($citySlug)
    {
        $city = City::where('slug', $citySlug)->firstOrFail();
        $kosts = Kost::with('city', 'images', 'facilities', 'kostType')
            ->where('city_id', $city->id)
            ->orderByDesc('is_featured')
            ->orderByDesc('is_recommended')
            ->latest()
            ->paginate(9);

        return view('kost.by-city', compact('city', 'kosts'));
    }

    public function show($citySlug, $slug)
    {
        $kost = Kost::with(['city', 'images', 'roomFacilities', 'sharedFacilities', 'nearbyPlaces', 'kostType'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Rekomendasi kost lain di kota yang sama — prioritaskan yang is_recommended
        $otherKosts = Kost::with('city', 'images', 'facilities', 'kostType')
            ->where('city_id', $kost->city_id)
            ->where('id', '!=', $kost->id)
            ->orderByDesc('is_recommended')
            ->orderByDesc('is_featured')
            ->take(3)
            ->get();

        $isUnlocked = false;
        if (auth()->check()) {
            $isUnlocked = auth()->user()->orders()
                ->where('kost_id', $kost->id)
                ->where('status', 'paid')
                ->exists();
        }

        return view('kost.show', compact('kost', 'otherKosts', 'isUnlocked'));
    }

    public function searchByCode(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
        ]);

        $kost = Kost::with('city')->where('kode', $request->kode)->first();

        if ($kost) {
            return redirect()->route('kost.show', ['citySlug' => $kost->city->slug, 'slug' => $kost->slug]);
        }

        return redirect()->back()->with('error', 'Kost dengan kode tersebut tidak ditemukan.');
    }
}
