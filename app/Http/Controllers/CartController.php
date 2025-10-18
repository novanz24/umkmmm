<?php
namespace App\Http\Controllers;

use App\Models\{Cart, CartItem, Product};
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->firstOrCreate([]);
        $items = $cart->items->map(fn($i)=>[
            'id'=>$i->id,
            'product_id'=>$i->product_id,
            'name'=>$i->product->name,
            'price'=>$i->product->price,
            'qty'=>$i->qty,
            'subtotal'=>$i->product->price * $i->qty,
        ]);
        $total = $items->sum('subtotal');

        return Inertia::render('Cart/Index', ['items'=>$items,'total'=>$total]);
    }

    public function add(Request $r)
    {
        $data = $r->validate([
            'product_id'=>['required','exists:products,id'],
            'qty'=>['required','integer','min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        abort_unless($product->is_active, 422, 'Produk tidak aktif');

        $cart = auth()->user()->cart()->firstOrCreate([]);

        // cek stok
        $existingQty = $cart->items()->where('product_id',$product->id)->value('qty') ?? 0;
        $newQty = $existingQty + $data['qty'];
        if ($newQty > $product->stock) {
            return back()->withErrors(['qty'=>'Stok tidak mencukupi']);
        }

        $cart->items()->updateOrCreate(
            ['product_id'=>$product->id],
            ['qty'=>$newQty]
        );

        return back()->with('ok','Ditambahkan ke keranjang');
    }

    public function update(Request $r, CartItem $item)
    {
        $this->authorizeItem($item);
        $data = $r->validate(['qty'=>['required','integer','min:1']]);

        $product = $item->product()->firstOrFail();
        if ($data['qty'] > $product->stock) {
            return back()->withErrors(['qty'=>'Stok tidak mencukupi']);
        }

        $item->update(['qty'=>$data['qty']]);
        return back();
    }

    public function destroy(CartItem $item)
    {
        $this->authorizeItem($item);
        $item->delete();
        return back();
    }

    private function authorizeItem(CartItem $item): void
    {
        abort_unless(
            $item->cart->user_id === auth()->id(),
            403,
            'Bukan milikmu'
        );
    }
}
