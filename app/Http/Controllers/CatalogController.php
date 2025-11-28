<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->where('is_active', true);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'title':
                    $query->orderBy('title', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $books = $query->paginate(12);
        $categories = Category::withCount('books')->get();

        // Return different view for authenticated users vs guests
        if (auth()->check() && auth()->user()->isUser()) {
            return view('catalog.user-index', compact('books', 'categories'));
        }

        return view('catalog.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        if (!$book->is_active) {
            abort(404);
        }

        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Return different view for authenticated users vs guests
        if (auth()->check() && auth()->user()->isUser()) {
            return view('catalog.user-show', compact('book', 'relatedBooks'));
        }

        return view('catalog.show', compact('book', 'relatedBooks'));
    }
}
