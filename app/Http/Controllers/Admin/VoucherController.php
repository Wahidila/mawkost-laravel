<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(20);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|integer|min:1',
            'min_amount' => 'nullable|integer|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'description' => 'nullable|string|max:255',
        ]);

        Voucher::create(array_merge(
            $request->only(['code', 'discount_type', 'discount_value', 'min_amount', 'max_uses', 'expires_at', 'description']),
            ['code' => strtoupper($request->code), 'is_active' => true]
        ));

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dibuat.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|integer|min:1',
            'min_amount' => 'nullable|integer|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'description' => 'nullable|string|max:255',
        ]);

        $voucher->update(array_merge(
            $request->only(['discount_type', 'discount_value', 'min_amount', 'max_uses', 'expires_at', 'description']),
            ['code' => strtoupper($request->code), 'is_active' => $request->has('is_active')]
        ));

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Voucher::findOrFail($id)->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus.');
    }
}
