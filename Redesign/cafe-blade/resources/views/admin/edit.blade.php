<x-app-layout>
<div class="mx-auto max-w-6xl px-4 pt-8 sm:px-6">
  <a href="{{ route('menu.index') }}" class="btn-ghost mb-6">&larr; Kembali ke menu</a>
  <p class="text-sm font-semibold uppercase tracking-widest text-[#c2603a]">Admin</p>
  <h1 class="mt-1 text-4xl font-semibold">Tambah menu dari API</h1>

  <form class="frost-card my-6 flex flex-col gap-3 p-4 sm:flex-row">
    <input name="q" value="{{ request('q') }}" placeholder="Cari resipi (cth: chicken)" class="input sm:flex-1">
    <button class="btn-primary">Cari API</button>
  </form>

  @if($errors->any())
    <div class="frost-card mb-6 px-5 py-3 text-sm text-[#a84f2e]">
      @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
    </div>
  @endif

  @if(request()->filled('q') && count($meals) === 0)
    <div class="frost-card p-12 text-center font-display text-xl">Tiada hasil untuk “{{ request('q') }}”.</div>
  @endif

  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach($meals as $m)
      <article class="frost-card card-lift flex flex-col overflow-hidden">
        <img src="{{ $m['strMealThumb'] }}" alt="{{ $m['strMeal'] }}" loading="lazy" class="aspect-[4/3] w-full object-cover">
        <div class="flex flex-1 flex-col p-5">
          <p class="text-xs font-semibold uppercase tracking-wider text-[#3b2a20]/50">{{ $m['strCategory'] ?? '' }}</p>
          <h3 class="mt-1 text-lg font-semibold">{{ $m['strMeal'] }}</h3>
          <div class="mt-auto pt-4">
            @if(in_array($m['idMeal'], $existing))
              <div class="rounded-2xl bg-[#3f5a43]/10 px-4 py-3 text-center text-sm font-medium text-[#3f5a43]">✓ Sudah ada dalam menu</div>
            @else
              <form method="POST" action="{{ route('admin.store') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="meal_id" value="{{ $m['idMeal'] }}">
                <div class="grid grid-cols-2 gap-2">
                  <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#3b2a20]/50">RM</span>
                    <input name="price" type="number" step="0.01" min="0" placeholder="0.00" class="input !pl-10" required>
                  </div>
                  <select name="status" class="input">
                    <option value="ada">Ada</option>
                    <option value="habis">Habis</option>
                  </select>
                </div>
                <button class="btn-primary w-full">+ Tambah</button>
              </form>
            @endif
          </div>
        </div>
      </article>
    @endforeach
  </div>
</div>
</x-app-layout>
