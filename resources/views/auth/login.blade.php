@extends('layouts.auth')

@section('title', 'Masuk ke Admin')

@section('content')

<form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf

    <div>
        <label for="email">Email</label>
        <input type="email"
               id="email"
               name="email"
               value="{{ old('email') }}"
               class="input-field @error('email') border-red-300 @enderror"
               placeholder="admin@cozyture.id"
               required autofocus autocomplete="email">
        @error('email')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password"
               id="password"
               name="password"
               class="input-field @error('password') border-red-300 @enderror"
               placeholder="••••••••"
               required autocomplete="current-password">
        @error('password')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" class="rounded border-sand/40 text-walnut focus:ring-walnut/20">
            <span class="text-xs text-charcoal/50 normal-case tracking-normal">Ingat saya</span>
        </label>
    </div>

    <button type="submit" class="btn-primary">
        Masuk
    </button>
</form>

@endsection