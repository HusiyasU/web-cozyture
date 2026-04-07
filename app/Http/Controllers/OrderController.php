<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $products = Product::with('category')
            ->active()
            ->inStock()
            ->ordered()
            ->get();

        // Pre-select produk jika datang dari halaman detail
        $selectedProduct = $request->filled('product')
            ? Product::active()->where('slug', $request->product)->first()
            : null;

        $categories = Category::active()->ordered()->get();

        return view('order.create', compact('products', 'selectedProduct', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'       => 'required|exists:products,id',
            'customer_name'    => 'required|string|max:100',
            'customer_email'   => 'required|email|max:100',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'quantity'         => 'required|integer|min:1|max:100',
            'notes'            => 'nullable|string|max:1000',
        ], [
            'product_id.required'       => 'Produk wajib dipilih.',
            'product_id.exists'         => 'Produk tidak ditemukan.',
            'customer_name.required'    => 'Nama lengkap wajib diisi.',
            'customer_email.required'   => 'Email wajib diisi.',
            'customer_email.email'      => 'Format email tidak valid.',
            'customer_phone.required'   => 'Nomor telepon wajib diisi.',
            'customer_address.required' => 'Alamat pengiriman wajib diisi.',
            'quantity.required'         => 'Jumlah wajib diisi.',
            'quantity.min'              => 'Jumlah minimal 1.',
        ]);

        $order = Order::create($validated);

        return redirect()
            ->route('order.thankyou', $order->order_number)
            ->with('success', 'Pesanan berhasil dikirim!');
    }

    public function thankyou(string $orderNumber)
    {
        $order = Order::with('product')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('order.thankyou', compact('order'));
    }
}