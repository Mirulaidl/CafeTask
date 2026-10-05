<x-app-layout>
<div class="mx-auto max-w-4xl px-4 pt-8 sm:px-6">
  <h1 class="mb-6 text-3xl font-semibold">Troli Anda</h1>

  @if(session('ok'))
    <div class="frost-card mb-6 border-[#3f5a43]/20 px-5 py-3 text-sm font-medium text-[#3f5a43]">{{ session('ok') }}</div>
  @endif
  @if($errors->any())
    <div class="frost-card mb-6 border-red-500/20 px-5 py-3 text-sm font-medium text-red-600">
      {{ $errors->first() }}
    </div>
  @endif

  @if(empty($cart))
    <div class="frost-card p-12 text-center">
      <p class="font-display text-xl text-gray-500">Troli kosong.</p>
      <a href="{{ route('menu.index') }}" class="mt-4 inline-block btn-primary">Lihat Menu</a>
    </div>
  @else
    <div class="frost-card overflow-hidden">
      <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="p-4 font-semibold">Menu</th>
            <th class="p-4 font-semibold">Harga</th>
            <th class="p-4 font-semibold">Kuantiti</th>
            <th class="p-4 font-semibold">Jumlah</th>
            <th class="p-4"></th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @foreach($cart as $id => $item)
          <tr>
            <td class="p-4 flex items-center gap-4">
              <img src="{{ $item['image'] }}/preview" class="w-16 h-16 rounded object-cover">
              <span class="font-medium">{{ $item['name'] }}</span>
            </td>
            <td class="p-4">RM {{ number_format($item['price'], 2) }}</td>
            <td class="p-4">{{ $item['quantity'] }}</td>
            <td class="p-4 font-semibold">RM {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
            <td class="p-4 text-right">
              <form action="{{ route('cart.remove', $id) }}" method="POST">
                @csrf
                <button class="text-red-500 hover:underline text-sm">Buang</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot class="bg-gray-50">
          <tr>
            <td colspan="3" class="p-4 text-right font-semibold text-lg">Jumlah Keseluruhan:</td>
            <td colspan="2" class="p-4 font-bold text-xl text-[#c2603a]">RM {{ number_format($total, 2) }}</td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="mt-6 flex justify-end gap-4">
      <a href="{{ route('menu.index') }}" class="btn-ghost">Tambah Lagi</a>
      <form action="{{ route('order.checkout') }}" method="POST">
        @csrf
        <button class="btn-primary px-8 py-3 text-lg">Buat Pesanan</button>
      </form>
    </div>
  @endif
</div>
</x-app-layout>
