<x-app-layout>
<div class="mx-auto max-w-6xl px-4 pt-8 sm:px-6">
  <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <p class="text-sm font-semibold uppercase tracking-widest text-[#c2603a]">Menu hari ini</p>
      <h1 class="mt-1 text-4xl font-semibold sm:text-5xl">Hidangan kami</h1>
    </div>
    @if(auth()->user()?->role === 'admin')
      <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.search') }}" class="btn-primary">+ Tambah dari API</a>
        <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data" class="m-0 flex items-center">
          @csrf
          <input type="file" name="csv_file" id="csv_file" accept=".csv" class="hidden" onchange="this.form.submit()">
          <label for="csv_file" class="btn-forest cursor-pointer m-0">Import CSV</label>
        </form>
        <a href="{{ route('admin.export') }}" class="btn-forest">Export CSV</a>
      </div>
    @endif
  </div>

  @if(session('ok'))
    <div class="frost-card mb-6 border-[#3f5a43]/20 px-5 py-3 text-sm font-medium text-[#3f5a43]">{{ session('ok') }}</div>
  @endif

  @if($errors->any())
    <div class="frost-card mb-6 border-red-500/20 px-5 py-3 text-sm font-medium text-red-600">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
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

  @if($isGrouped)
    @forelse($items as $category => $categoryItems)
      <div class="mb-10">
        <h2 class="mb-6 text-3xl font-display font-semibold text-[#3b2a20] border-b-2 border-[#c2603a]/20 pb-2">{{ $category ?: 'Lain-lain' }}</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          @foreach($categoryItems as $i)
            @include('menu.partials.card', ['i' => $i])
          @endforeach
        </div>
      </div>
    @empty
      <div class="frost-card p-12 text-center">
        <p class="text-4xl">🍽️</p>
        <p class="mt-3 font-display text-xl">Tiada menu dijumpai.</p>
      </div>
    @endforelse
  @else
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse($items as $i)
        @include('menu.partials.card', ['i' => $i])
      @empty
        <div class="frost-card col-span-full p-12 text-center">
          <p class="text-4xl">🍽️</p>
          <p class="mt-3 font-display text-xl">Tiada menu dijumpai.</p>
        </div>
      @endforelse
    </div>

    <div class="mt-10">{{ $items->links() }}</div>
  @endif
</div>
</x-app-layout>
