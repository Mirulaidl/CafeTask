<x-app-layout>
<div class="mx-auto max-w-6xl px-4 pt-8 sm:px-6">
  <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <p class="text-sm font-semibold uppercase tracking-widest text-[#c2603a]">Menu hari ini</p>
      <h1 class="mt-1 text-4xl font-semibold sm:text-5xl">Hidangan kami</h1>
    </div>
    @if(auth()->user()?->role === 'admin')
      <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.search') }}" class="btn-primary">+ Tambah dari API</a>
        <a href="{{ route('admin.export') }}" class="btn-forest">Export CSV</a>
      </div>
    @endif
  </div>

  @if(session('ok'))
    <div class="frost-card mb-6 border-[#3f5a43]/20 px-5 py-3 text-sm font-medium text-[#3f5a43]">{{ session('ok') }}</div>
  @endif

  <form class="frost-card mb-6 flex flex-col gap-3 p-4 sm:flex-row">
    <input name="q" value="{{ request('q') }}" placeholder="Cari menu..." class="input sm:flex-1">
    <button class="btn-primary sm:w-auto">Cari</button>
  </form>

  {{-- Category chips --}}
  <div class="mb-8 flex gap-2 overflow-x-auto pb-1">
    <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}"
       class="shrink-0 rounded-full px-4 py-2 text-sm font-medium {{ !request('category') ? 'bg-[#3b2a20] text-white' : 'bg-white/60 hover:bg-white' }}">Semua</a>
    @foreach($categories as $c)
      <a href="{{ request()->fullUrlWithQuery(['category' => $c, 'page' => null]) }}"
         class="shrink-0 rounded-full px-4 py-2 text-sm font-medium {{ request('category') === $c ? 'bg-[#3b2a20] text-white' : 'bg-white/60 hover:bg-white' }}">{{ $c }}</a>
    @endforeach
  </div>

  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($items as $i)
      <article class="frost-card card-lift flex flex-col overflow-hidden">
        <a href="{{ route('menu.show', $i) }}" class="relative block aspect-[4/3] overflow-hidden">
          <img src="{{ $i->image }}" alt="{{ $i->name }}" loading="lazy" class="h-full w-full object-cover transition duration-500 hover:scale-105 {{ $i->status === 'habis' ? 'grayscale-[60%]' : '' }}">
          <div class="absolute left-3 top-3"><x-status-badge :status="$i->status" /></div>
        </a>
        <div class="flex flex-1 flex-col p-5">
          <p class="text-xs font-semibold uppercase tracking-wider text-[#3b2a20]/50">{{ $i->category }}</p>
          <a href="{{ route('menu.show', $i) }}"><h3 class="mt-1 text-xl font-semibold hover:text-[#c2603a]">{{ $i->name }}</h3></a>
          <div class="mt-auto flex items-center justify-between pt-4">
            <span class="font-display text-2xl font-semibold text-[#c2603a]">RM {{ number_format($i->price, 2) }}</span>
            @if(auth()->user()?->role === 'admin')
              <div class="flex gap-1">
                <a href="{{ route('admin.edit', $i) }}" class="rounded-full px-3 py-1.5 text-sm font-medium text-[#3f5a43] hover:bg-[#3f5a43]/10">Edit</a>
                <form method="POST" action="{{ route('admin.destroy', $i) }}" onsubmit="return confirm('Padam menu ini?')">
                  @csrf @method('DELETE')
                  <button class="rounded-full px-3 py-1.5 text-sm font-medium text-[#a84f2e] hover:bg-[#c2603a]/10">Padam</button>
                </form>
              </div>
            @endif
          </div>
        </div>
      </article>
    @empty
      <div class="frost-card col-span-full p-12 text-center">
        <p class="text-4xl">🍽️</p>
        <p class="mt-3 font-display text-xl">Tiada menu dijumpai.</p>
      </div>
    @endforelse
  </div>

  <div class="mt-10">{{ $items->withQueryString()->links() }}</div>
</div>
</x-app-layout>
