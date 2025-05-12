<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
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
     * Display the user's cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = auth()->user()->cart;

        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }

        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Yetersiz stok. Mevcut stok: ' . $product->stock);
        }

        $cart = auth()->user()->cart;

        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }

        $cart->addProduct($product->id, $quantity);

        return redirect()->route('cart.index')->with('success', 'Ürün sepete eklendi.');
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = auth()->user()->cart;
        $cartItem = $cart->items()->findOrFail($request->item_id);
        $quantity = $request->input('quantity');

        // Stok kontrolü
        if ($cartItem->product->stock < $quantity) {
            return redirect()->back()->with('error', 'Yetersiz stok. Mevcut stok: ' . $cartItem->product->stock);
        }

        $cartItem->update(['quantity' => $quantity]);

        return redirect()->route('cart.index')->with('success', 'Sepet güncellendi.');
    }

    /**
     * Remove a product from the cart.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function remove(Product $product)
    {
        $cart = auth()->user()->cart;
        $cartItem = $cart->items()->where('product_id', $product->id)->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Ürün sepetten çıkarıldı.');
    }

    /**
     * Clear the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        $cart = auth()->user()->cart;
        
        if ($cart) {
            $cart->clear();
        }

        return redirect()->route('cart.index')->with('success', 'Sepet temizlendi.');
    }

    /**
     * Proceed to checkout.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $cart = auth()->user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş.');
        }

        // Check if all products are in stock
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'Ürün "' . $item->product->name . '" için yetersiz stok. Mevcut stok: ' . $item->product->stock);
            }
        }

        $user = auth()->user();

        return view('cart.checkout', compact('cart', 'user'));
    }
}
