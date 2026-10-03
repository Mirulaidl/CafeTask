<x-app-layout>
<div class="mx-auto max-w-lg px-4 pt-8 sm:px-6">
  <a href="{{ route('menu.index') }}" class="btn-ghost mb-6">&larr; Kembali</a>
  <form method="POST" action="{{ route('admin.update', $item) }}" class="frost-card overflow-hidden">
    @csrf @method('PUT')
    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="aspect-[16/9] w-full object-cover">
    <div class="space-y-5 p-6 sm:p-8">
      <div>
        <p class="text-sm font-semibold uppercase tracking-widest text-[#c2603a]">Edit menu</p>
        <h1 class="mt-1 text-3xl font-semibold">{{ $item->name }}</h1>
      </div>
      <label class="block">
        <span class="mb-1.5 block text-sm font-medium">Harga (RM)</span>
        <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $item->price) }}" class="input" required>
        @error('price')<span class="mt-1 block text-sm text-[#a84f2e]">{{ $message }}</span>@enderror
      </label>
      <fieldset>
        <span class="mb-1.5 block text-sm font-medium">Status</span>
        <div class="grid grid-cols-2 gap-2">
          @foreach(['ada' => 'Ada', 'habis' => 'Habis'] as $val => $label)
            <label class="cursor-pointer">
              <input type="radio" name="status" value="{{ $val }}" class="peer sr-only" @checked(old('status', $item->status) === $val)>
              <span class="block rounded-2xl border border-[#3b2a20]/15 bg-white/60 px-4 py-3 text-center text-sm font-semibold peer-checked:border-[#c2603a] peer-checked:bg-[#c2603a] peer-checked:text-white">{{ $label }}</span>
            </label>
          @endforeach
        </div>
      </fieldset>
      <button class="btn-primary w-full">Simpan</button>
    </div>
  </form>
</div>
</x-app-layout>
