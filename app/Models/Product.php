<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'brand',
        'description',
        'price',
        'stock',
        'is_active',
        'is_featured'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get product images.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the primary image for the product.
     */
    public function primaryImage()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    /**
     * Get the image path for the product.
     */
    public function getImagePathAttribute()
    {
        // 1. Ürüne atanmış birincil görsel varsa onu kullan (ki bu genelde gitarlar klasöründeki bir görsel olacak)
        $primaryImage = $this->primaryImage();
        if ($primaryImage && !empty($primaryImage->image_path)) {
            $imagePathFromRecord = $primaryImage->image_path;
            if (file_exists(public_path($imagePathFromRecord))) {
                return asset($imagePathFromRecord);
            }
        }

        // 2. Varsayılan olarak gitarlar klasöründen bir görsel kullan
        $defaultGuitarImage = 'storage/products/default/gitarlar/default.jpg';
        if (file_exists(public_path($defaultGuitarImage))) {
            return asset($defaultGuitarImage);
        }

        // 3. En genel varsayılan resim
        $generalDefaultImage = 'storage/products/default/default.jpg';
        if (file_exists(public_path($generalDefaultImage))) {
            return asset($generalDefaultImage);
        }

        // 4. Son çare
        return asset('storage/products/default/image-not-found.png');
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include in-stock products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include featured products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    protected static function boot()
    {
        parent::boot();
        
        // Slug oluşturma
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
        
        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}

