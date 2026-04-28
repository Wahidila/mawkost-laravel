<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\KostAlert;
use App\Models\KostType;
use App\Services\KostAlertService;
use Illuminate\Http\Request;

class KostAlertController extends Controller
{
    public function index()
    {
        $alerts = auth()->user()->kostAlerts()
            ->with(['city', 'kostType'])
            ->latest()
            ->get();

        $cities = City::orderBy('name')->get();
        $kostTypes = KostType::orderBy('name')->get();

        return view('user.alerts.index', compact('alerts', 'cities', 'kostTypes'));
    }

    public function store(Request $request)
    {
        if (!KostAlertService::isEnabled()) {
            return back()->with('error', 'Fitur alert kost sedang tidak aktif.');
        }

        $request->validate([
            'city_id' => 'nullable|exists:cities,id',
            'kost_type_id' => 'nullable|exists:kost_types,id',
            'max_price' => 'nullable|integer|min:50000',
            'channel' => 'required|in:email,whatsapp,both',
        ]);

        $existing = auth()->user()->kostAlerts()->count();
        if ($existing >= 5) {
            return back()->with('error', 'Maksimal 5 alert per akun.');
        }

        auth()->user()->kostAlerts()->create($request->only([
            'city_id', 'kost_type_id', 'max_price', 'channel',
        ]));

        return back()->with('success', 'Alert berhasil ditambahkan! Kamu akan diberitahu saat ada kost baru yang cocok.');
    }

    public function toggle($id)
    {
        $alert = auth()->user()->kostAlerts()->findOrFail($id);
        $alert->update(['is_active' => !$alert->is_active]);

        $status = $alert->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Alert berhasil {$status}.");
    }

    public function destroy($id)
    {
        auth()->user()->kostAlerts()->findOrFail($id)->delete();
        return back()->with('success', 'Alert berhasil dihapus.');
    }
}
