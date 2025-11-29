<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons
     */
    public function index()
    {
        $coupons = Coupon::withCount('usages')
            ->latest()
            ->paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'is_first_purchase_only' => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_first_purchase_only'] = $request->boolean('is_first_purchase_only');

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Kupon berhasil dibuat!');
    }

    /**
     * Show the form for editing the coupon
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the coupon
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'is_first_purchase_only' => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_first_purchase_only'] = $request->boolean('is_first_purchase_only');

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Kupon berhasil diperbarui!');
    }

    /**
     * Remove the coupon
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Kupon berhasil dihapus!');
    }

    /**
     * Toggle coupon status
     */
    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);

        return back()->with('success', 'Status kupon berhasil diubah!');
    }

    /**
     * Generate random code
     */
    public function generateCode()
    {
        return response()->json([
            'code' => Coupon::generateCode(),
        ]);
    }
}
