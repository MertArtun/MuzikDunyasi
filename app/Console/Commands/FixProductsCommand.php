<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FixProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bozuk ürün görsellerini ve stok durumlarını düzeltir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Ürün sorunları düzeltiliyor...');

        // Bozuk görselleri düzelt
        $this->fixBrokenImages();

        // Stok durumlarını düzelt
        $this->fixStockStatuses();

        $this->info('Ürün sorunları başarıyla düzeltildi!');
        
        return Command::SUCCESS;
    }

    /**
     * Bozuk görselleri düzelt
     */
    private function fixBrokenImages()
    {
        $this->info('Bozuk görseller kontrol ediliyor...');
        
        // 1. Resim yolu boş olan ürünleri kategori bazlı varsayılan görseller ile güncelle
        $count1 = DB::statement("
            UPDATE products p
            JOIN categories c ON p.category_id = c.id
            SET p.image_path = CONCAT('products/default/', c.slug, '.jpg')
            WHERE p.image_path IS NULL OR p.image_path = ''
        ");
        $this->info("Resim yolu boş olan ürünler güncellendi");

        // 2. Fotoğrafı olmayan ürün görselleri tablosundaki kayıtları düzelt
        $count2 = DB::statement("
            UPDATE product_images pi
            JOIN products p ON pi.product_id = p.id
            JOIN categories c ON p.category_id = c.id
            SET pi.image_path = CONCAT('products/default/', c.slug, '.jpg')
            WHERE pi.image_path IS NULL OR pi.image_path = ''
        ");
        $this->info("Resim yolu boş olan ürün görselleri güncellendi");

        // 3. Primary olarak işaretli görsel olmayan ürünler için varsayılan görselleri oluştur
        $count3 = DB::statement("
            INSERT INTO product_images (product_id, image_path, is_primary, created_at, updated_at)
            SELECT p.id, CONCAT('products/default/', c.slug, '.jpg'), 1, NOW(), NOW()
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
            WHERE pi.id IS NULL
        ");
        $this->info("Primary görsel eksik olan ürünler için yeni görseller oluşturuldu");

        // 4. Tüm ürünleri kontrol et ve eksik görselleri düzelt
        $products = Product::all();
        $fixedCount = 0;

        foreach ($products as $product) {
            if (!$product->image_path || !Storage::disk('public')->exists($product->image_path)) {
                $category = Category::find($product->category_id);
                $categorySlug = $category ? $category->slug : 'default';
                $defaultImagePath = "products/default/{$categorySlug}.jpg";
                
                if (!Storage::disk('public')->exists($defaultImagePath)) {
                    $defaultImagePath = "products/default/default.jpg";
                }
                
                if (Storage::disk('public')->exists($defaultImagePath)) {
                    $product->image_path = $defaultImagePath;
                    $product->save();
                    
                    // ProductImage güncelle veya oluştur
                    ProductImage::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'is_primary' => true
                        ],
                        [
                            'image_path' => $defaultImagePath
                        ]
                    );
                    
                    $fixedCount++;
                }
            }
        }
        
        $this->info("{$fixedCount} ürün görseli manuel olarak düzeltildi");
    }
    
    /**
     * Stok durumlarını düzelt
     */
    private function fixStockStatuses()
    {
        $this->info('Stok durumları kontrol ediliyor...');
        
        // Stok durumu 0 olan veya boş olan ürünleri bul
        $count = DB::statement("
            UPDATE products
            SET stock = FLOOR(10 + RAND() * 90)
            WHERE stock = 0 OR stock IS NULL
        ");
        
        $this->info("Stok durumu 0 veya boş olan ürünler rastgele stok miktarları ile güncellendi.");
    }
} 