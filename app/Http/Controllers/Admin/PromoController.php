<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /**
     * Display a listing of promos
     */
    public function index()
    {
        $promos = Promo::withCount('books')
            ->latest()
            ->paginate(10);

        return view('admin.promos.index', compact('promos'));
    }

    /**
     * Show the form for creating a new promo
     */
    public function create()
    {
        $books = Book::where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('admin.promos.create', compact('books'));
    }

    /**
     * Store a newly created promo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:flash_sale,seasonal,clearance,bundle',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'banner_image' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'apply_to_all_books' => 'boolean',
            'book_ids' => 'nullable|array',
            'book_ids.*' => 'exists:books,id',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('promos', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['apply_to_all_books'] = $request->boolean('apply_to_all_books');

        $promo = Promo::create($validated);

        // Attach books if not applying to all
        if (!$promo->apply_to_all_books && $request->has('book_ids')) {
            $promo->books()->attach($request->book_ids);
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dibuat!');
    }

    /**
     * Show the form for editing the promo
     */
    public function edit(Promo $promo)
    {
        $books = Book::where('is_active', true)
            ->orderBy('title')
            ->get();

        $selectedBooks = $promo->books->pluck('id')->toArray();

        return view('admin.promos.edit', compact('promo', 'books', 'selectedBooks'));
    }

    /**
     * Update the promo
     */
    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:flash_sale,seasonal,clearance,bundle',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'banner_image' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'apply_to_all_books' => 'boolean',
            'book_ids' => 'nullable|array',
            'book_ids.*' => 'exists:books,id',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($promo->banner_image) {
                Storage::disk('public')->delete($promo->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('promos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['apply_to_all_books'] = $request->boolean('apply_to_all_books');

        $promo->update($validated);

        // Sync books
        if (!$promo->apply_to_all_books) {
            $promo->books()->sync($request->book_ids ?? []);
        } else {
            $promo->books()->detach();
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui!');
    }

    /**
     * Remove the promo
     */
    public function destroy(Promo $promo)
    {
        if ($promo->banner_image) {
            Storage::disk('public')->delete($promo->banner_image);
        }

        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dihapus!');
    }

    /**
     * Toggle promo status
     */
    public function toggle(Promo $promo)
    {
        $promo->update(['is_active' => !$promo->is_active]);

        return back()->with('success', 'Status promo berhasil diubah!');
    }
}
