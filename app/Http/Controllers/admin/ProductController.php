<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage'])
            ->withCount('orders');

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter status
        if ($request->filled('status')) {
            match ($request->status) {
                'active'   => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'featured' => $query->where('is_featured', true),
                default    => null,
            };
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('material', 'like', "%{$search}%");
            });
        }

        $products   = $query->ordered()->paginate(15)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        DB::transaction(function () use ($validated, $request) {
            $validated['slug'] ??= Str::slug($validated['name']);

            $product = Product::create($validated);

            // Upload gambar jika ada
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path'       => $path,
                        'alt'        => $product->name,
                        'is_primary' => $index === 0, // gambar pertama jadi primary
                        'sort_order' => $index,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'orders' => fn($q) => $q->latest()->take(5)]);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::active()->ordered()->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);

        DB::transaction(function () use ($validated, $request, $product) {
            $validated['slug'] ??= Str::slug($validated['name']);

            $product->update($validated);

            // Upload gambar baru jika ada
            if ($request->hasFile('images')) {
                $lastOrder = $product->images()->max('sort_order') ?? -1;

                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');

                    $isPrimary = $product->images()->count() === 0 && $index === 0;

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path'       => $path,
                        'alt'        => $product->name,
                        'is_primary' => $isPrimary,
                        'sort_order' => $lastOrder + $index + 1,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Hapus semua gambar dari storage terlebih dahulu
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // ===== IMAGE MANAGEMENT =====

    public function uploadImage(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $path      = $request->file('image')->store('products', 'public');
        $lastOrder = $product->images()->max('sort_order') ?? -1;
        $hasPrimary = $product->images()->where('is_primary', true)->exists();

        $image = ProductImage::create([
            'product_id' => $product->id,
            'path'       => $path,
            'alt'        => $product->name,
            'is_primary' => ! $hasPrimary, // jadi primary jika belum ada
            'sort_order' => $lastOrder + 1,
        ]);

        return back()->with('success', 'Gambar berhasil diunggah.');
    }

    public function deleteImage(Product $product, ProductImage $image)
    {
        $wasPrimary = $image->is_primary;

        Storage::disk('public')->delete($image->path);
        $image->delete();

        // Jika gambar yang dihapus adalah primary, set gambar berikutnya sebagai primary
        if ($wasPrimary) {
            $next = $product->images()->orderBy('sort_order')->first();
            $next?->update(['is_primary' => true]);
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function setPrimaryImage(Product $product, ProductImage $image)
    {
        $image->makePrimary();

        return back()->with('success', 'Foto utama berhasil diubah.');
    }

    // ===== PRIVATE =====

    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:200',
            'slug'              => 'nullable|string|max:220|unique:products,slug' . ($ignoreId ? ",{$ignoreId}" : ''),
            'short_description' => 'nullable|string|max:300',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'material'          => 'nullable|string|max:100',
            'dimension'         => 'nullable|string|max:100',
            'color'             => 'nullable|string|max:50',
            'stock'             => 'required|integer|min:0',
            'is_active'         => 'boolean',
            'is_featured'       => 'boolean',
            'sort_order'        => 'integer|min:0',
            'images.*'          => 'image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'name.required'        => 'Nama produk wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'stock.required'       => 'Stok wajib diisi.',
            'images.*.image'       => 'File harus berupa gambar.',
            'images.*.max'         => 'Ukuran gambar maksimal 3MB.',
        ]);
    }
}
