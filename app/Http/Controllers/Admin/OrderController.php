<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return Inertia::render('Admin/Orders/Index', ['orders'=>$orders]);
    }

    public function updateStatus(Request $r, Order $order)
    {
        $data = $r->validate(['status'=>['required','in:diproses,dikirim,selesai,batal']]);
        $order->update(['status'=>$data['status']]);
        return back()->with('ok','Status diperbarui');
    }
}
