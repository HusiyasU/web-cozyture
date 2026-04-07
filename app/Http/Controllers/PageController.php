<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        $settings = Setting::getMany([
            'store_phone',
            'store_email',
            'store_address',
            'store_maps_url',
            'social_whatsapp',
            'social_instagram',
        ]);

        return view('pages.contact', compact('settings'));
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        // Untuk saat ini hanya redirect balik dengan notif sukses.
        // Nanti bisa ditambahkan: Mail::to(...)->send(new ContactMail($request->all()))

        return back()->with('success', 'Pesan kamu berhasil dikirim! Kami akan segera menghubungi kamu.');
    }
}