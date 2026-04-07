<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->active()
            ->featured()
            ->ordered()
            ->take(6)
            ->get();

        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}