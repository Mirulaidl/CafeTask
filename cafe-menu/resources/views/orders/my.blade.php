<x-app-layout>
<div class="mx-auto max-w-4xl px-4 pt-8 sm:px-6">
  <h1 class="mb-6 text-3xl font-semibold">Sejarah Pesanan Anda</h1>

  @if(session('ok'))
    <div class="frost-card mb-6 border-[#3f5a43]/20 px-5 py-3 text-sm font-medium text-[#3f5a43]">{{ session('ok') }}</div>
  @endif

  @if($orders->isEmpty())
    <div class="frost-card p-12 text-center">
      <p class="font-display text-xl text-gray-500">Tiada pesanan lagi.</p>
      <a href="{{ route('menu.index') }}" class="mt-4 inline-block btn-primary">Lihat Menu</a>
    </div>
  @else
    <div class="space-y-6">
      @foreach($orders as $order)
      <div class="frost-card overflow-hidden">
        <div class="bg-gray-50 p-4 border-b flex justify-between items-center">
          <div>
            <span class="font-semibold">Pesanan #{{ $order->id }}</span>
            <span class="text-sm text-gray-500 ml-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
          </div>
          <div>
            @if($order->status === 'pending')
              <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 uppercase">Sedang Disediakan</span>
            @else
              <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 uppercase">Selesai</span>
            @endif
          </div>
        </div>
        <div class="p-4">
          <ul class="divide-y text-sm">
            @foreach($order->items as $item)
              <li class="py-2 flex justify-between">
                <span>{{ $item->quantity }}x {{ $item->menuItem->name ?? 'Menu dipadam' }}</span>
                <span>RM {{ number_format($item->price * $item->quantity, 2) }}</span>
              </li>
            @endforeach
          </ul>
          <div class="mt-4 pt-4 border-t flex justify-between font-bold text-lg">
            <span>Jumlah:</span>
            <span>RM {{ number_format($order->total_price, 2) }}</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>
</x-app-layout>
