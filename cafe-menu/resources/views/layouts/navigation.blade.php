<nav x-data="{ open: false }" class="sticky top-0 z-30 px-4 pt-4 sm:px-6">
  <div class="frost-card mx-auto flex max-w-6xl items-center justify-between px-5 py-3">
    <a href="{{ route('menu.index') }}" class="flex items-center gap-2">
      <span class="grid h-9 w-9 place-items-center rounded-full bg-[#c2603a] text-lg text-white">☕</span>
      <span class="font-display text-lg font-semibold">{{ config('app.name', 'Kafe') }}</span>
    </a>
    <div class="hidden items-center gap-2 sm:flex">
      <a href="{{ route('menu.index') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('menu.*') ? 'bg-[#3b2a20] text-white' : 'hover:bg-white/70' }}">Menu</a>
      @if(auth()->user()?->role === 'admin')
        <a href="{{ route('admin.orders.index') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-[#3b2a20] text-white' : 'hover:bg-white/70' }}">Pesanan</a>
        <a href="{{ route('admin.search') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.search') ? 'bg-[#3b2a20] text-white' : 'hover:bg-white/70' }}">API Menu</a>
      @endif
      @auth
        @if(auth()->user()?->role !== 'admin')
          <a href="{{ route('cart.index') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('cart.*') ? 'bg-[#3b2a20] text-white' : 'hover:bg-white/70' }}">Troli ({{ count(session('cart', [])) }})</a>
          <a href="{{ route('order.my') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('order.*') ? 'bg-[#3b2a20] text-white' : 'hover:bg-white/70' }}">Pesanan Saya</a>
        @endif
        <span class="ml-2 text-sm text-[#3b2a20]/60">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn-ghost !py-2">Log keluar</button></form>
      @else
        <a href="{{ route('login') }}" class="btn-primary !py-2">Log masuk</a>
      @endauth
    </div>
    <button @click="open = !open" class="rounded-full p-2 hover:bg-white/70 sm:hidden" aria-label="Menu">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
  <div x-show="open" x-transition class="frost-card mx-auto mt-2 max-w-6xl space-y-1 p-3 sm:hidden">
    <a href="{{ route('menu.index') }}" class="block rounded-2xl px-4 py-2 hover:bg-white/70">Menu</a>
    @if(auth()->user()?->role === 'admin')
      <a href="{{ route('admin.orders.index') }}" class="block rounded-2xl px-4 py-2 hover:bg-white/70">Pesanan</a>
      <a href="{{ route('admin.search') }}" class="block rounded-2xl px-4 py-2 hover:bg-white/70">API Menu</a>
    @endif
    @auth
      @if(auth()->user()?->role !== 'admin')
        <a href="{{ route('cart.index') }}" class="block rounded-2xl px-4 py-2 hover:bg-white/70">Troli ({{ count(session('cart', [])) }})</a>
        <a href="{{ route('order.my') }}" class="block rounded-2xl px-4 py-2 hover:bg-white/70">Pesanan Saya</a>
      @endif
      <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-2xl px-4 py-2 text-left hover:bg-white/70">Log keluar</button></form>
    @else
      <a href="{{ route('login') }}" class="block rounded-2xl px-4 py-2 hover:bg-white/70">Log masuk</a>
    @endauth
  </div>
</nav>
