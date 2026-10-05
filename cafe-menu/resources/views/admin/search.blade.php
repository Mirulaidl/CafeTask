<x-app-layout>
<div class="max-w-4xl mx-auto p-6">
  <a href="{{ route('menu.index') }}" class="underline">&larr; Kembali ke menu</a>
  <div class="my-4">
    <form class="flex gap-2">
      <input name="q" value="{{ request('q') }}" placeholder="Cari resipi (cth: chicken)" class="border rounded px-2 flex-1">
      <button class="bg-gray-800 text-white px-3 rounded">Cari API</button>
    </form>
  </div>

  <div class="mb-6">
    <h3 class="font-semibold text-gray-700 mb-2">Pilih Kategori:</h3>
    <div class="flex flex-wrap gap-2">
      @foreach($categories as $cat)
        <a href="{{ route('admin.search', ['c' => $cat]) }}" class="px-3 py-1 border rounded text-sm {{ request('c') === $cat ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-50' }}">
          {{ $cat }}
        </a>
      @endforeach
    </div>
  </div>

  @error('meal_id')<div class="text-red-600 mb-2">{{ $message }}</div>@enderror
  @error('price')<div class="text-red-600 mb-2">{{ $message }}</div>@enderror

  @if((request()->filled('q') || request()->filled('c')) && count($meals) === 0)
    <p>Tiada hasil.</p>
  @elseif(!request()->filled('q') && !request()->filled('c'))
    <p class="text-gray-500">Sila buat carian atau pilih kategori di atas untuk melihat senarai menu yang boleh ditambah dari API.</p>
  @endif

  @foreach($meals as $m)
  <div class="flex items-center gap-4 border-t py-3">
    <img src="{{ $m['strMealThumb'] }}/preview" class="w-20 h-20 rounded">
    <div class="flex-1"><b>{{ $m['strMeal'] }}</b><br>{{ $m['strCategory'] }}</div>
    @if(in_array($m['idMeal'],$existing))
      <span class="text-gray-500">Sudah ada dalam menu</span>
    @else
      <form method="POST" action="{{ route('admin.store') }}" class="flex gap-2">
        @csrf
        <input type="hidden" name="meal_id" value="{{ $m['idMeal'] }}">
        <input name="price" type="number" step="0.01" placeholder="Harga" class="border rounded w-24 px-2" required>
        <select name="status" class="border rounded">
          <option value="ada">Ada</option><option value="habis">Habis</option>
        </select>
        <button class="bg-blue-600 text-white px-3 rounded">Tambah</button>
      </form>
    @endif
  </div>
  @endforeach
</div>
</x-app-layout>
