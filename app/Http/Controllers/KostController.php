<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Kost;
use Illuminate\Http\Request;

class KostController extends Controller
{
    public function search(Request $request)
    {
        $query = Kost::with('city', 'images', 'facilities')->available();

        if ($request->filled('lokasi')) {
            $city = City::where('slug', $request->lokasi)->first();
            if ($city) {
                $query->where('city_id', $city->id);
            }
        }

        if ($request->filled('tipe')) {
            $query->where('type', $request->tipe);
        }

        if ($request->filled('min_harga')) {
            $query->where('price', '>=', $request->min_harga);
        }

        if ($request->filled('max_harga')) {
            $query->where('price', '<=', $request->max_harga);
        }

        $kosts = $query->paginate(9)->withQueryString();
        $cities = City::orderBy('name')->get();

        return view('kost.search', compact('kosts', 'cities'));
    }

    public function byCity($citySlug)
    {
        $city = City::where('slug', $citySlug)->firstOrFail();
        $kosts = Kost::with('city', 'images', 'facilities')
            ->where('city_id', $city->id)
            ->available()
            ->paginate(9);

        return view('kost.by-city', compact('city', 'kosts'));
    }

    public function show($citySlug, $slug)
    {
        $kost = Kost::with(['city', 'images', 'roomFacilities', 'sharedFacilities', 'nearbyPlaces'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Rekomendasi kost lain di kota yang sama
        $otherKosts = Kost::with('city', 'images', 'facilities')
            ->where('city_id', $kost->city_id)
            ->where('id', '!=', $kost->id)
            ->available()
            ->take(3)
            ->get();

        return view('kost.show', compact('kost', 'otherKosts'));
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
