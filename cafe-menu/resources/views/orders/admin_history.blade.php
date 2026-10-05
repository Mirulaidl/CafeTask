<x-app-layout>
<div class="mx-auto max-w-6xl px-4 pt-8 sm:px-6">
  <div class="mb-6 flex justify-between items-end">
    <h1 class="text-3xl font-semibold">Sejarah Pesanan (Selesai)</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn-primary">Kembali ke Pesanan Semasa</a>
  </div>

  @if($orders->isEmpty())
    <div class="frost-card p-12 text-center">
      <p class="font-display text-xl text-gray-500">Tiada sejarah pesanan.</p>
    </div>
  @else
    <div class="frost-card overflow-hidden">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="p-4">ID Pesanan</th>
            <th class="p-4">Tarikh</th>
            <th class="p-4">Pelanggan</th>
            <th class="p-4">Butiran</th>
            <th class="p-4">Jumlah</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @foreach($orders as $order)
          <tr>
            <td class="p-4 font-semibold">#{{ $order->id }}</td>
            <td class="p-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td class="p-4">{{ $order->user->name }}</td>
            <td class="p-4">
              <ul class="list-disc pl-4">
                @foreach($order->items as $item)
                  <li>{{ $item->quantity }}x {{ $item->menuItem->name ?? 'Menu dipadam' }}</li>
                @endforeach
              </ul>
            </td>
            <td class="p-4 font-semibold">RM {{ number_format($order->total_price, 2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
</x-app-layout>
