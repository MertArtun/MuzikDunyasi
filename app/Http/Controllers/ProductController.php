<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestedCategoryId = $request->query('category');
        $instrumentType = $request->query('instrument_type');
        $search = $request->query('search');
        $sort = $request->query('sort', 'newest');
        
        $priceMin = $request->query('price_min');
        $priceMax = $request->query('price_max');
        $inStock = $request->query('in_stock');
        $isFeatured = $request->query('is_featured');
        $isNew = $request->query('is_new');
        $brands = $request->query('brands', []);
        $perPage = $request->query('per_page', 12);

        \Log::info("Initial filter parameters:", [
            'requested_category_id' => $requestedCategoryId,
            'instrument_type' => $instrumentType,
            'search' => $search,
            'sort' => $sort,
            'brands' => $brands
        ]);

        $categoryId = null; // Initialize final categoryId

        // Predefined valid category IDs (ensure these are correct and have products)
        $instrumentTypeToCategoryIdMap = [
            'guitar' => 1,
            'piano' => 5,
            'drums' => 12,
            'bass' => 4,
            'wind' => 16,
            'strings' => 9,
            // Add other direct mappings from instrument_type to a valid category_id
            // Ensure these IDs correspond to categories that are known to have products
        ];
        
        // If instrument_type is provided, it takes precedence
        if ($instrumentType) {
            $lowercaseType = strtolower($instrumentType);
            foreach ($instrumentTypeToCategoryIdMap as $key => $id) {
                if (str_contains($lowercaseType, $key)) {
                    $categoryId = $id;
                    \Log::info("Category ID set by instrument_type mapping.", [
                        'instrument_type' => $instrumentType,
                        'matched_key' => $key,
                        'categoryId' => $categoryId
                    ]);
                    break;
                }
            }
        }

        // If categoryId is not set by instrument_type, and a category ID is requested, process it
        if (!$categoryId && $requestedCategoryId) {
            $category = Category::find($requestedCategoryId);
            if ($category) {
                // Check if the directly requested category has products
                if ($category->products()->count() > 0) {
                    $categoryId = $category->id;
                    \Log::info("Category ID set by direct request (has products).", [
                        'requested_category_id' => $requestedCategoryId,
                        'categoryName' => $category->name,
                        'categoryId' => $categoryId
                    ]);
                } else {
                    // Requested category has no products, look for a duplicate by name with products
                    \Log::info("Requested category has no products. Looking for duplicate.", [
                        'requested_category_id' => $requestedCategoryId,
                        'categoryName' => $category->name
                    ]);
                    $similarCategoryWithProducts = Category::where('name', 'like', $category->name)
                                                ->where('id', '!=', $category->id) // Exclude the original empty one
                                                ->whereHas('products') // Crucial: only if it has products
                                                ->withCount('products')
                                                ->orderBy('products_count', 'desc')
                                                ->first();
                    if ($similarCategoryWithProducts) {
                        $categoryId = $similarCategoryWithProducts->id;
                        \Log::info("Switched to similar category with products.", [
                            'original_requested_id' => $requestedCategoryId,
                            'original_name' => $category->name,
                            'found_category_id' => $similarCategoryWithProducts->id,
                            'found_category_name' => $similarCategoryWithProducts->name,
                            'products_count' => $similarCategoryWithProducts->products_count
                        ]);
                    } else {
                        \Log::warning("No direct products for requested category ID, and no duplicate with products found by name.", [
                            'requested_category_id' => $requestedCategoryId,
                            'categoryName' => $category->name
                        ]);
                        // $categoryId remains null, so no products will be shown for this specific problematic request.
                    }
                }
            } else {
                \Log::warning("Requested category ID not found in database.", ['requested_category_id' => $requestedCategoryId]);
            }
        }
        
        // If instrument_type was present, it might have set categoryId.
        // If category filter was directly used, it might have also set categoryId.
        // We need to ensure that if $request->filled('category'), it clears $instrumentType so that
        // the category dropdown selection has priority if both are somehow in the URL.
        // However, the logic above already prioritizes instrument_type if present.
        // If only 'category' is in query, $instrumentType will be null, and the second block will run.
        // If both are, $instrumentType runs, sets $categoryId, then second block sees $categoryId is already set.

        \Log::info("Final Category ID for query:", [
            'final_category_id' => $categoryId
        ]);

        $productsQuery = Product::with('category')->active();
        
        if ($inStock === '1') {
            $productsQuery->inStock();
        } elseif ($inStock === '0') {
            $productsQuery->where('stock', 0);
        }

        if ($categoryId) {
            $productsQuery->where(function($query) use ($categoryId) {
                $query->where('category_id', $categoryId)
                      ->orWhereHas('category', function($q) use ($categoryId) {
                          $q->where('parent_id', $categoryId);
                      });
            });
            \Log::info("Product query with category filter:", [
                'category_id' => $categoryId,
                'sql' => $productsQuery->toSql(),
                'bindings' => $productsQuery->getBindings()
            ]);
        } else {
            \Log::info("Product query without category filter (categoryId is null).");
        }

        if ($search) {
            $productsQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }
        
        if ($priceMin) {
            $productsQuery->where('price', '>=', $priceMin);
        }
        
        if ($priceMax) {
            $productsQuery->where('price', '<=', $priceMax);
        }
        
        if ($isFeatured === '1') {
            $productsQuery->where('is_featured', true);
        }
        
        if ($isNew === '1') {
            $productsQuery->where('created_at', '>=', now()->subDays(30));
        }
        
        if (!empty($brands)) {
            $productsQuery->whereIn('brand', $brands);
        }

        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'popular':
                $productsQuery->withCount('orderItems')->orderBy('order_items_count', 'desc');
                break;
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->paginate($perPage);
        
        \Log::info("Product query result:", [
            'total_products_found' => $products->total(),
            'current_page' => $products->currentPage(),
            'per_page' => $products->perPage(),
        ]);
        
        $categories = Category::withCount('products')
                    ->having('products_count', '>', 0) // Only categories with products
                    ->orderBy('name')
                    ->get();
        
        $allBrands = DB::table('products')
            ->select('brand')
            ->whereNotNull('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand')
            ->toArray();
        
        $priceRange = DB::table('products')
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        // Pass $categoryId (the one used for filtering) to the view, not $requestedCategoryId
        return view('products.index', compact(
            'products', 
            'categories', 
            'categoryId',  // This is the resolved categoryId
            'instrumentType',
            'search', 
            'sort',
            'priceMin',
            'priceMax',
            'inStock',
            'isFeatured',
            'isNew',
            'brands',
            'allBrands',
            'priceRange',
            'perPage'
        ));
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Her ana kategoriden bir ürün al
        $categories = \App\Models\Category::whereNull('parent_id')->pluck('id');
        
        $relatedProducts = collect();
        
        // Her ana kategoriden bir ürün ekle
        foreach ($categories as $categoryId) {
            $relatedProduct = Product::where('category_id', $categoryId)
                ->where('id', '!=', $product->id) // Şu anki ürünü hariç tut
                ->active()
                ->inStock()
                ->first();
                
            if ($relatedProduct) {
                $relatedProducts->push($relatedProduct);
            }
        }
        
        return view('products.show', compact('product', 'relatedProducts'));
    }
}
