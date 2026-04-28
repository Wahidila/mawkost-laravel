<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.team.index', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = 'storage/' . $path;
        }

        $validated['sort_order'] = TeamMember::max('sort_order') + 1;

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);
        return view('admin.team.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo && Str::startsWith($member->photo, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $member->photo));
            }
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = 'storage/' . $path;
        }

        if ($request->has('remove_photo')) {
            if ($member->photo && Str::startsWith($member->photo, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $member->photo));
            }
            $validated['photo'] = null;
        }

        $member->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);

        if ($member->photo && Str::startsWith($member->photo, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $member->photo));
        }

        $member->delete();

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
