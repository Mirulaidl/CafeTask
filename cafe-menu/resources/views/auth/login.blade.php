{{-- Replaces Breeze's resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log masuk — {{ config('app.name', 'Kafe') }}</title>
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|fraunces:500,600,700&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-screen place-items-center px-4 py-10 antialiased">
  <div class="frost-card w-full max-w-md p-8 sm:p-10">
    <div class="mb-8 text-center">
      <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-[#c2603a] text-2xl text-white">☕</span>
      <h1 class="mt-4 text-3xl font-semibold">Selamat kembali</h1>
      <p class="mt-1 text-sm text-[#3b2a20]/60">Log masuk untuk urus menu kafe</p>
    </div>
    @if(session('status'))<p class="mb-4 text-sm text-[#3f5a43]">{{ session('status') }}</p>@endif
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <label class="block">
        <span class="mb-1.5 block text-sm font-medium">Emel</span>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="input">
        @error('email')<span class="mt-1 block text-sm text-[#a84f2e]">{{ $message }}</span>@enderror
      </label>
      <label class="block">
        <span class="mb-1.5 block text-sm font-medium">Kata laluan</span>
        <input type="password" name="password" required autocomplete="current-password" class="input">
        @error('password')<span class="mt-1 block text-sm text-[#a84f2e]">{{ $message }}</span>@enderror
      </label>
      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center gap-2"><input type="checkbox" name="remember" class="rounded border-[#3b2a20]/30 text-[#c2603a] focus:ring-[#c2603a]"> Ingat saya</label>
        @if(Route::has('password.request'))<a href="{{ route('password.request') }}" class="font-medium text-[#c2603a] hover:underline">Lupa kata laluan?</a>@endif
      </div>
      <button class="btn-primary w-full !py-3">Log masuk</button>
    </form>
  </div>
</body>
</html>
