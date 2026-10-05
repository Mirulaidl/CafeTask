<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['message' => 'Troli kosong.']);
        }

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $total,
            'status' => 'pending'
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order.my')->with('ok', 'Pesanan berjaya dibuat!');
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())->with('items.menuItem')->latest()->get();
        return view('orders.my', compact('orders'));
    }

    // Admin Methods
    public function index()
    {
        $orders = Order::where('status', 'pending')->with(['items.menuItem', 'user'])->latest()->get();
        return view('orders.admin_index', compact('orders'));
    }

    public function finish(Order $order)
    {
        $order->update(['status' => 'finished']);
        return back()->with('ok', 'Pesanan diselesaikan.');
    }

    public function history()
    {
        $orders = Order::where('status', 'finished')->with(['items.menuItem', 'user'])->latest()->get();
        return view('orders.admin_history', compact('orders'));
    }
}
