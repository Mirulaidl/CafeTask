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
      @elseif(auth()->check() && $i->status === 'ada')
        <form method="POST" action="{{ route('cart.add') }}" class="flex gap-1">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $i->id }}">
            <input type="number" name="quantity" value="1" min="1" class="w-14 rounded border-gray-300 px-2 py-1 text-sm">
            <button class="rounded-full bg-[#3b2a20] px-3 py-1.5 text-sm font-medium text-white hover:bg-[#c2603a]">Tambah</button>
        </form>
      @endif
    </div>
  </div>
</article>
