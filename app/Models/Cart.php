<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in the cart.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the total price of the cart.
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Get the total number of items in the cart.
     *
     * @return int
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    /**
     * Add a product to the cart.
     *
     * @param  int  $productId
     * @param  int  $quantity
     * @return CartItem
     */
    public function addProduct($productId, $quantity = 1)
    {
        $item = $this->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $item = $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $item;
    }

    /**
     * Remove a product from the cart.
     *
     * @param  int  $productId
     * @return void
     */
    public function removeProduct($productId)
    {
        $this->items()->where('product_id', $productId)->delete();
    }

    /**
     * Clear the cart.
     *
     * @return void
     */
    public function clear()
    {
        $this->items()->delete();
    }
}
