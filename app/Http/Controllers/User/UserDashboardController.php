<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalOrders = $user->orders()->where('status', 'paid')->count();
        $totalSpent = $user->orders()->where('status', 'paid')->sum('amount');
        $recentOrders = $user->orders()->with('kost.city')->where('status', 'paid')->latest()->take(5)->get();

        return view('user.dashboard', compact('user', 'totalOrders', 'totalSpent', 'recentOrders'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('kost.city')->where('status', 'paid')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = auth()->user()->orders()->with('kost.city', 'kost.images', 'kost.facilities')->where('status', 'paid')->findOrFail($id);
        return view('user.orders.show', compact('order'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'whatsapp' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only('name', 'email', 'whatsapp');

        // Handle avatar upload (direct to public/avatars, no symlink needed)
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && File::exists(public_path($user->avatar))) {
                File::delete(public_path($user->avatar));
            }
            $file = $request->file('avatar');
            $filename = 'avatar-' . $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $data['avatar'] = 'avatars/' . $filename;
        }

        $user->update($data);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update(['password' => Hash::make($request->password)]);

        return redirect()->route('user.profile')->with('success', 'Password berhasil diubah!');
    }

    public function deleteAvatar()
    {
        $user = auth()->user();

        if ($user->avatar && File::exists(public_path($user->avatar))) {
            File::delete(public_path($user->avatar));
        }

        $user->update(['avatar' => null]);

        return redirect()->route('user.profile')->with('success', 'Foto profil berhasil dihapus!');
    }
}
