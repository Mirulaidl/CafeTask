<x-app-layout>
<div class="mx-auto max-w-5xl px-4 pt-8 sm:px-6">
  <a href="{{ route('menu.index') }}" class="btn-ghost mb-6">&larr; Kembali</a>
  <div class="frost-card grid overflow-hidden md:grid-cols-2">
    <div class="relative aspect-square md:aspect-auto">
      <img src="{{ $item->image }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
      <div class="absolute left-4 top-4"><x-status-badge :status="$item->status" /></div>
    </div>
    <div class="p-6 sm:p-10">
      <div class="flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-wider">
        <span class="rounded-full bg-[#3b2a20]/5 px-3 py-1">{{ $item->category }}</span>
        @if($item->area)<span class="rounded-full bg-[#3b2a20]/5 px-3 py-1">{{ $item->area }}</span>@endif
      </div>
      <h1 class="mt-4 text-4xl font-semibold">{{ $item->name }}</h1>
      <p class="mt-2 font-display text-3xl font-semibold text-[#c2603a]">RM {{ number_format($item->price, 2) }}</p>

      <h2 class="mt-8 text-xl font-semibold">Bahan &amp; Sukatan</h2>
      <ul class="mt-4 divide-y divide-[#3b2a20]/10 rounded-2xl bg-white/50">
        @forelse($item->ingredients ?? [] as $g)
          <li class="flex items-center justify-between gap-4 px-4 py-3 text-sm">
            <span class="font-medium">{{ $g['name'] }}</span>
            <span class="rounded-full bg-[#3f5a43]/10 px-3 py-1 text-xs font-semibold text-[#3f5a43]">{{ $g['measure'] }}</span>
          </li>
        @empty
          <li class="px-4 py-3 text-sm text-[#3b2a20]/60">Tiada maklumat bahan.</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
</x-app-layout>
