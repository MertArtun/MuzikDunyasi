<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of all orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        
        $ordersQuery = Order::with('user');
        
        if ($status) {
            $ordersQuery->where('status', $status);
        }
        
        if ($search) {
            $ordersQuery->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $orders = $ordersQuery->latest()->paginate(10);
        
        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $statuses = $order->statusHistory()->orderBy('created_at', 'asc')->get();
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Approve the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function approve(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Bu sipariş zaten onaylanmış veya iptal edilmiş.');
        }

        // Update order status
        OrderStatus::create([
            'order_id' => $order->id,
            'status' => 'approved',
        ]);

        $order->update(['status' => 'approved']);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Sipariş başarıyla onaylandı.');
    }

    /**
     * Update the status of the specified order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:processing,packaging,shipping,in_transit,delivered',
        ]);

        $newStatus = $request->input('status');
        
        // Check if the status transition is valid
        $validTransitions = [
            'approved' => ['processing'],
            'processing' => ['packaging'],
            'packaging' => ['shipping'],
            'shipping' => ['in_transit'],
            'in_transit' => ['delivered'],
        ];

        if (!isset($validTransitions[$order->status]) || !in_array($newStatus, $validTransitions[$order->status])) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Geçersiz durum geçişi.');
        }

        // Add order status
        OrderStatus::create([
            'order_id' => $order->id,
            'status' => $newStatus,
        ]);

        // Update order status
        $order->update(['status' => $newStatus]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Sipariş durumu güncellendi.');
    }

    /**
     * Cancel the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Bu sipariş zaten onaylanmış veya iptal edilmiş.');
        }

        // Add order status
        OrderStatus::create([
            'order_id' => $order->id,
            'status' => 'canceled',
        ]);

        // Update order status
        $order->update(['status' => 'canceled']);

        // Return items to stock
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        // Add to user balance
        $user = $order->user;
        $user->increment('balance', $order->total_amount);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Sipariş iptal edildi ve müşterinin bakiyesine eklendi.');
    }
}
