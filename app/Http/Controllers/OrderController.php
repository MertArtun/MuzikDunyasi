<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $statuses = $order->statusHistory()->orderBy('created_at', 'asc')->get();
        
        return view('orders.show', compact('order', 'statuses'));
    }

    /**
     * Process payment and create a new order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'address' => 'required|string|max:255',
                'payment_method' => 'required|in:credit_card,balance',
            ]);

            $user = auth()->user();
            $cart = $user->cart;

            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Sepetiniz boş.');
            }

            // Start a database transaction
            return DB::transaction(function () use ($request, $user, $cart) {
                // Calculate total amount
                $totalAmount = $cart->total;
                
                // Check if using balance
                $paymentMethod = $request->input('payment_method');
                $useBalance = $paymentMethod === 'balance' || $user->balance > 0;
                
                // If using balance, check if balance is sufficient
                if ($useBalance) {
                    // Use as much of the balance as possible
                    $amountFromBalance = min($totalAmount, $user->balance);
                    $amountFromCreditCard = $totalAmount - $amountFromBalance;
                    
                    // Update user balance
                    if ($amountFromBalance > 0) {
                        $user->balance -= $amountFromBalance;
                        $user->save();
                    }
                } else {
                    $amountFromCreditCard = $totalAmount;
                }

                // TODO: Process credit card payment if needed
                // This would be an integration with a payment gateway
                
                // Create the order
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                    'address' => $request->input('address'),
                ]);

                // Create order items
                foreach ($cart->items as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->product->price,
                    ]);
                    
                    // Update product stock
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                }

                // Create initial order status
                OrderStatus::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                ]);

                // Clear the cart
                $cart->clear();

                // Redirect to confirmation page instead of order details
                return redirect()->route('orders.confirmation', $order)->with('success', 'Siparişiniz başarıyla oluşturuldu.');
            });
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Order creation failed: ' . $e->getMessage());
            
            // Detailed error message for debugging
            return redirect()->route('cart.checkout')->with('error', 'Sipariş oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Cancel the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if the order can be canceled
        if (!$order->canBeCanceled()) {
            return redirect()->route('orders.show', $order)->with('error', 'Bu sipariş iptal edilemez.');
        }

        // Start a database transaction
        return DB::transaction(function () use ($order) {
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

            return redirect()->route('orders.show', $order)->with('success', 'Sipariş iptal edildi ve bakiyenize eklendi.');
        });
    }

    /**
     * Mark the order as received by the customer.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function markAsReceived(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if the order is delivered
        if ($order->status !== 'delivered') {
            return redirect()->route('orders.show', $order)->with('error', 'Bu sipariş henüz teslim edilmedi.');
        }

        // Update order status
        OrderStatus::create([
            'order_id' => $order->id,
            'status' => 'completed',
        ]);

        $order->update(['status' => 'completed']);

        return redirect()->route('orders.show', $order)->with('success', 'Siparişiniz tamamlandı.');
    }

    /**
     * Display the order confirmation page.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function confirmation(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        return view('orders.confirmation', compact('order'));
    }
}
