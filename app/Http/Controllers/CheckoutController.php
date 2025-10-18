<?php
namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\{Order, OrderItem, Product};
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function form()
    {
        $cart = auth()->user()->cart()->with('items.product')->firstOrCreate([]);
        $sum  = $cart->items->sum(fn($i)=>$i->product->price * $i->qty);
        return Inertia::render('Checkout/Form', ['total'=>$sum]);
    }

    public function store(CheckoutRequest $req)
    {
        $user = auth()->user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->withErrors(['cart'=>'Keranjang kosong']);
        }

        DB::transaction(function () use ($req, $user, $cart) {
            // Validasi stok & aktif
            foreach ($cart->items as $ci) {
                if (!$ci->product->is_active) abort(422, 'Ada produk non-aktif');
                if ($ci->qty > $ci->product->stock) abort(422, 'Stok tidak cukup');
            }

            $order = Order::create([
                'user_id' => $user->id,
                'address_text' => $req->address_text,
                'status' => 'diproses',
                'total' => 0,
            ]);

            $total = 0;
            foreach ($cart->items as $ci) {
                $price = $ci->product->price;
                $subtotal = $price * $ci->qty;
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$ci->product_id,
                    'price'=>$price,
                    'qty'=>$ci->qty,
                    'subtotal'=>$subtotal,
                ]);
                // Kurangi stok
                Product::whereKey($ci->product_id)->decrement('stock', $ci->qty);
                $total += $subtotal;
            }

            $order->update(['total'=>$total]);

            // Kosongkan keranjang
            $cart->items()->delete();
        });

        return to_route('orders.index')->with('ok', 'Pesanan berhasil dibuat!');

    }
}
