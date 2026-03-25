<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Kost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cities = City::withCount('kosts')->orderBy('name')->get();
        $recommendedKosts = Kost::with('city', 'images', 'facilities')
            ->recommended()
            ->available()
            ->take(6)
            ->get();

        $recentKosts = Kost::with('city', 'images', 'facilities')
            ->available()
            ->latest()
            ->take(3)
            ->get();

        $kostCount = Kost::count();
        $cityCount = City::count();

        return view('home', compact('cities', 'recommendedKosts', 'recentKosts', 'kostCount', 'cityCount'));
    }
}
