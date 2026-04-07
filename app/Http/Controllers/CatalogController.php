<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) Setting::get('products_per_page', 12);

        $query = Product::with(['category', 'primaryImage'])
            ->active();

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter stok
        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('material', 'like', "%{$search}%");
            });
        }

        // Sorting
        match ($request->get('sort', 'default')) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest'     => $query->orderByDesc('created_at'),
            default      => $query->ordered(),
        };

        $products   = $query->paginate($perPage)->withQueryString();
        $categories = Category::active()->ordered()->get();

        // Aktif kategori saat ini
        $activeCategory = $request->filled('category')
            ? Category::where('slug', $request->category)->first()
            : null;

        return view('catalog.index', compact('products', 'categories', 'activeCategory'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'images'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Produk terkait dari kategori yang sama
        $related = Product::with(['primaryImage'])
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->ordered()
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'related'));
    }
}