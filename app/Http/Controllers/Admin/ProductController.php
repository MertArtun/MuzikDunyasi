<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Arama filtresi
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Stok durumu filtreleri
        if ($request->has('stock')) {
            if ($request->stock === 'low') {
                $query->where('stock', '<=', 5)->where('stock', '>', 0);
            } elseif ($request->stock === 'out') {
                $query->where('stock', '<=', 0);
            }
        }
        
        // Aktiflik durumu filtreleri
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        // Kategori filtresi
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->latest()->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'is_active' => 'required|boolean',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Create the product
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'is_active' => $request->is_active ? true : false,
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    try {
                        $path = $image->store('products', 'public');
                        
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $path,
                            'is_primary' => $index === 0, // First image is primary
                        ]);
                    } catch (\Exception $imageEx) {
                        \Log::error('Image upload failed: ' . $imageEx->getMessage());
                        // Continue with other images even if one fails
                    }
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Ürün başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            \Log::error('Product creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ürün eklenirken bir hata oluştu: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'is_active' => 'required|boolean',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Update the product
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'is_active' => $request->is_active ? true : false,
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                // If there are existing images and the primary image is not in the request,
                // keep the first existing image as primary
                $hasPrimary = $product->images()->where('is_primary', true)->exists();
                
                foreach ($request->file('images') as $index => $image) {
                    try {
                        $path = $image->store('products', 'public');
                        
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $path,
                            'is_primary' => !$hasPrimary && $index === 0, // First image is primary if no primary exists
                        ]);
                    } catch (\Exception $imageEx) {
                        \Log::error('Image upload failed during product update: ' . $imageEx->getMessage());
                        // Continue with other images even if one fails
                    }
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Ürün başarıyla güncellendi.');
        } catch (\Exception $e) {
            \Log::error('Product update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ürün güncellenirken bir hata oluştu: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Ürün başarıyla silindi.');
    }

    /**
     * Delete a product image.
     *
     * @param  \App\Models\ProductImage  $image
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($image)
    {
        $image = ProductImage::findOrFail($image);
        $productId = $image->product_id;
        $isPrimary = $image->is_primary;

        // Delete the image file
        Storage::disk('public')->delete($image->image_path);
        
        // Delete the image record
        $image->delete();

        // If the deleted image was primary, set another image as primary
        if ($isPrimary) {
            $newPrimaryImage = ProductImage::where('product_id', $productId)->first();
            if ($newPrimaryImage) {
                $newPrimaryImage->update(['is_primary' => true]);
            }
        }

        return redirect()->back()->with('success', 'Ürün görseli başarıyla silindi.');
    }

    /**
     * Store a new product image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            
            // Check if this is the first image
            $isPrimary = !$product->images()->exists();
            
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => $isPrimary,
            ]);
        }

        return redirect()->back()->with('success', 'Ürün görseli başarıyla eklendi.');
    }

    /**
     * Set an image as the primary image for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setPrimaryImage(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id',
        ]);

        $image = ProductImage::findOrFail($request->image_id);
        
        // Remove primary flag from all other images of this product
        ProductImage::where('product_id', $image->product_id)
            ->update(['is_primary' => false]);
        
        // Set this image as primary
        $image->update(['is_primary' => true]);

        return redirect()->back()->with('success', 'Ana görsel başarıyla güncellendi.');
    }
}
