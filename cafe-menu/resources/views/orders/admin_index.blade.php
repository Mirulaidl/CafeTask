<x-app-layout>
<div class="mx-auto max-w-6xl px-4 pt-8 sm:px-6">
  <div class="mb-6 flex justify-between items-end">
    <h1 class="text-3xl font-semibold">Pesanan Semasa (Pending)</h1>
    <a href="{{ route('admin.orders.history') }}" class="btn-ghost">Lihat Sejarah Pesanan</a>
  </div>

  @if(session('ok'))
    <div class="frost-card mb-6 border-[#3f5a43]/20 px-5 py-3 text-sm font-medium text-[#3f5a43]">{{ session('ok') }}</div>
  @endif

  @if($orders->isEmpty())
    <div class="frost-card p-12 text-center">
      <p class="font-display text-xl text-gray-500">Tiada pesanan baru yang sedang diproses.</p>
    </div>
  @else
    <div class="grid gap-6 md:grid-cols-2">
      @foreach($orders as $order)
      <div class="frost-card overflow-hidden flex flex-col">
        <div class="bg-gray-50 p-4 border-b flex justify-between items-center">
          <div>
            <span class="font-semibold text-lg">Pesanan #{{ $order->id }}</span>
            <div class="text-sm text-gray-600">Pelanggan: {{ $order->user->name }}</div>
          </div>
          <div class="text-right text-sm text-gray-500">
            {{ $order->created_at->format('d/m/Y H:i') }}<br>
            {{ $order->created_at->diffForHumans() }}
          </div>
        </div>
        <div class="p-4 flex-1">
          <ul class="divide-y text-sm">
            @foreach($order->items as $item)
              <li class="py-2 flex justify-between">
                <span>{{ $item->quantity }}x {{ $item->menuItem->name ?? 'Menu dipadam' }}</span>
                <span>RM {{ number_format($item->price * $item->quantity, 2) }}</span>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="p-4 bg-gray-50 border-t flex justify-between items-center">
          <div class="font-bold text-xl text-[#c2603a]">RM {{ number_format($order->total_price, 2) }}</div>
          <form action="{{ route('admin.orders.finish', $order) }}" method="POST">
            @csrf
            <button class="btn-primary">Selesai</button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>
</x-app-layout>
