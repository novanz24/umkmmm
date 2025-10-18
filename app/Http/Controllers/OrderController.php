<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10)
            ->through(function ($o) {
                return [
                    'id'          => $o->id,
                    'total'       => $o->total,
                    'status'      => $o->status,
                    'created_at'  => $o->created_at->format('d M Y H:i'),
                    'items_count' => $o->items->sum('qty'),
                ];
            });

        return Inertia::render('Orders/Index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        // pastikan hanya pemilik yang bisa lihat
        abort_if($order->user_id !== $request->user()->id, 403);

        $order->load('items.product');

        return Inertia::render('Orders/Show', [
            'order' => [
                'id'          => $order->id,
                'status'      => $order->status,
                'total'       => $order->total,
                'address_text'=> $order->address_text,
                'created_at'  => $order->created_at->format('d M Y H:i'),
                'items'       => $order->items->map(fn ($i) => [
                    'id'       => $i->id,
                    'name'     => $i->product?->name,
                    'price'    => $i->price,
                    'qty'      => $i->qty,
                    'subtotal' => $i->subtotal,
                ]),
            ],
        ]);
    }
}
