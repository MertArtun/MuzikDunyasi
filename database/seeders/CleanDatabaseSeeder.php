<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

class CleanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Önce mevcut ürün resimleri, ürünler ve kategoriler temizlenir
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ProductImage::truncate();
        Product::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Ana kategoriler oluşturulur
        $categoriesData = [
            ['id' => 1, 'name' => 'Gitarlar', 'slug' => 'gitarlar', 'image_folder' => 'gitarlar'],
            ['id' => 5, 'name' => 'Piyanolar', 'slug' => 'piyanolar', 'image_folder' => 'piyanolar'],
            ['id' => 12, 'name' => 'Davullar ve Perküsyon', 'slug' => 'davullar-perkusyon', 'image_folder' => 'davullar'],
            ['id' => 9, 'name' => 'Yaylı Çalgılar', 'slug' => 'yayli-calgilar', 'image_folder' => 'yayli-calgilar'],
            ['id' => 16, 'name' => 'Nefesli Çalgılar', 'slug' => 'nefesli-calgilar', 'image_folder' => 'nefesli-calgilar'],
            ['id' => 20, 'name' => 'Stüdyo Ekipmanları', 'slug' => 'studyo-ekipmanlari', 'image_folder' => 'studyo-ekipmanlari'],
        ];

        // Alt kategoriler için de ana kategorilerin image_folder'ını kullanacağız
        $allCategories = [
            ['id' => 1, 'name' => 'Gitarlar', 'slug' => 'gitarlar', 'description' => 'Her türlü gitar çeşitleri', 'parent_id' => null, 'image_folder' => 'gitarlar'],
            ['id' => 2, 'name' => 'Akustik Gitarlar', 'slug' => 'akustik-gitarlar', 'description' => 'Akustik gitarlar', 'parent_id' => 1, 'image_folder' => 'gitarlar'],
            ['id' => 3, 'name' => 'Elektro Gitarlar', 'slug' => 'elektro-gitarlar', 'description' => 'Elektro gitarlar', 'parent_id' => 1, 'image_folder' => 'gitarlar'],
            ['id' => 4, 'name' => 'Bas Gitarlar', 'slug' => 'bas-gitarlar', 'description' => 'Bas gitarlar', 'parent_id' => 1, 'image_folder' => 'gitarlar'],
            ['id' => 5, 'name' => 'Piyanolar', 'slug' => 'piyanolar', 'description' => 'Her türlü piyano çeşitleri', 'parent_id' => null, 'image_folder' => 'piyanolar'],
            ['id' => 6, 'name' => 'Akustik Piyanolar', 'slug' => 'akustik-piyanolar', 'description' => 'Akustik piyanolar', 'parent_id' => 5, 'image_folder' => 'piyanolar'],
            ['id' => 7, 'name' => 'Dijital Piyanolar', 'slug' => 'dijital-piyanolar', 'description' => 'Dijital piyanolar', 'parent_id' => 5, 'image_folder' => 'piyanolar'],
            ['id' => 8, 'name' => 'Klavyeler', 'slug' => 'klavyeler', 'description' => 'Klavyeler', 'parent_id' => 5, 'image_folder' => 'piyanolar'], // Klavyeler de piyano resimleri kullanabilir
            ['id' => 9, 'name' => 'Yaylı Çalgılar', 'slug' => 'yayli-calgilar', 'description' => 'Yaylı çalgılar', 'parent_id' => null, 'image_folder' => 'yayli-calgilar'],
            ['id' => 10, 'name' => 'Kemanlar', 'slug' => 'kemanlar', 'description' => 'Kemanlar', 'parent_id' => 9, 'image_folder' => 'yayli-calgilar'],
            ['id' => 11, 'name' => 'Viyolalar', 'slug' => 'viyolalar', 'description' => 'Viyolalar', 'parent_id' => 9, 'image_folder' => 'yayli-calgilar'],
            ['id' => 12, 'name' => 'Davullar ve Perküsyon', 'slug' => 'davullar-perkusyon', 'description' => 'Davullar ve perküsyon aletleri', 'parent_id' => null, 'image_folder' => 'davullar'],
            ['id' => 13, 'name' => 'Akustik Davullar', 'slug' => 'akustik-davullar', 'description' => 'Akustik davullar', 'parent_id' => 12, 'image_folder' => 'davullar'],
            ['id' => 14, 'name' => 'Elektronik Davullar', 'slug' => 'elektronik-davullar', 'description' => 'Elektronik davullar', 'parent_id' => 12, 'image_folder' => 'davullar'],
            ['id' => 15, 'name' => 'Perküsyon', 'slug' => 'perkusyon', 'description' => 'Perküsyon aletleri', 'parent_id' => 12, 'image_folder' => 'davullar'],
            ['id' => 16, 'name' => 'Nefesli Çalgılar', 'slug' => 'nefesli-calgilar', 'description' => 'Nefesli çalgılar', 'parent_id' => null, 'image_folder' => 'nefesli-calgilar'],
            ['id' => 17, 'name' => 'Flütler', 'slug' => 'flutler', 'description' => 'Flütler', 'parent_id' => 16, 'image_folder' => 'nefesli-calgilar'],
            ['id' => 18, 'name' => 'Klarnetler', 'slug' => 'klarnetler', 'description' => 'Klarnetler', 'parent_id' => 16, 'image_folder' => 'nefesli-calgilar'],
            ['id' => 19, 'name' => 'Saksafonlar', 'slug' => 'saksafonlar', 'description' => 'Saksafonlar', 'parent_id' => 16, 'image_folder' => 'nefesli-calgilar'],
            ['id' => 20, 'name' => 'Stüdyo Ekipmanları', 'slug' => 'studyo-ekipmanlari', 'description' => 'Stüdyo ekipmanları', 'parent_id' => null, 'image_folder' => 'studyo-ekipmanlari'],
        ];
        
        foreach ($allCategories as $categoryData) {
            Category::create([
                'id' => $categoryData['id'],
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'],
                'parent_id' => $categoryData['parent_id'],
            ]);
        }
        
        // Marka ve Model tanımlamaları aynı kalabilir...
        $guitarBrands = ['Fender', 'Gibson', 'Ibanez', 'Yamaha', 'Taylor', 'Martin', 'Epiphone', 'ESP', 'PRS', 'Cort', 'Schecter', 'Gretsch'];
        $guitarModels = ['Stratocaster', 'Telecaster', 'Les Paul', 'SG', 'RG Series', 'SE Custom', 'Dreadnought', 'F Series', 'FG', 'GS', 'Folk'];
        $pianoBrands = ['Yamaha', 'Steinway', 'Kawai', 'Roland', 'Casio', 'Korg', 'Baldwin', 'Nord', 'Kurzweil', 'Fazioli'];
        $pianoModels = ['Grand Piano', 'Digital Piano', 'P-125', 'FP-30X', 'Clavinova', 'AP Series', 'GB1', 'ES Series', 'MX Series', 'Kronos'];
        $drumBrands = ['Pearl', 'Tama', 'DW', 'Ludwig', 'Gretsch', 'Yamaha', 'Mapex', 'Sonor', 'Zildjian', 'Roland'];
        $drumModels = ['Session Studio', 'Superstar Classic', 'Collector\'s Series', 'Classic Maple', 'Broadkaster', 'Stage Custom', 'Mars Series', 'SQ2', 'TD-17KVX', 'Export Series'];
        $stringBrands = ['Stentor', 'Yamaha', 'Eastman', 'Stradivarius', 'Cremona', 'Knilling', 'Scott Cao', 'Cecilio', 'D Z Strad', 'Fiddlerman'];
        $stringModels = ['Student Series', 'V5', 'VL100', 'Conservatory', 'Master Series', 'Artist Series', 'Workshop Series', 'Professional', 'Academy', 'Soloist'];
        $windBrands = ['Yamaha', 'Jupiter', 'Selmer', 'Bach', 'Buffet Crampon', 'Conn-Selmer', 'Armstrong', 'Fox', 'Leblanc', 'Muramatsu'];
        $windModels = ['YFL-222', 'JFL710', 'Series II', 'Student Series', 'R13', 'Artiste Series', 'Model 104', 'Renard', 'Vito', 'EX Series'];
        $studioBrands = ['Shure', 'Audio-Technica', 'Focusrite', 'Universal Audio', 'Korg', 'Akai', 'Native Instruments', 'Ableton', 'PreSonus', 'Yamaha'];
        $studioModels = ['SM7B', 'AT2020', 'Scarlett 2i2', 'Apollo Twin', 'Minilogue XD', 'MPC Live', 'Maschine MK3', 'Push 2', 'StudioLive', 'MODX7'];
        
        // Kategorilere göre ürünler oluşturulur
        // Kategori ID'si ve resim klasörü adını eşleştirerek createProductsForCategory çağır
        foreach ($allCategories as $cat) {
            if ($cat['id'] == 1) $this->createProductsForCategory($cat['id'], $guitarBrands, $guitarModels, 'gitar', 10, $cat['image_folder']);
            if ($cat['id'] == 5) $this->createProductsForCategory($cat['id'], $pianoBrands, $pianoModels, 'piyano', 10, $cat['image_folder']);
            if ($cat['id'] == 12) $this->createProductsForCategory($cat['id'], $drumBrands, $drumModels, 'davul', 10, $cat['image_folder']);
            if ($cat['id'] == 9) $this->createProductsForCategory($cat['id'], $stringBrands, $stringModels, 'yayli-calgi', 10, $cat['image_folder']);
            if ($cat['id'] == 16) $this->createProductsForCategory($cat['id'], $windBrands, $windModels, 'nefesli-calgi', 10, $cat['image_folder']);
            if ($cat['id'] == 20) $this->createProductsForCategory($cat['id'], $studioBrands, $studioModels, 'studyo-ekipmani', 10, $cat['image_folder']);
        }
    }
    
    /**
     * Belirli bir kategori için ürünler oluşturur.
     *
     * @param int $categoryId
     * @param array $brands
     * @param array $models
     * @param string $type
     * @param int $count
     * @param string $categoryImageFolder Kategoriye özel resimlerin bulunduğu klasör adı
     * @return void
     */
    private function createProductsForCategory($categoryId, $brands, $models, $type, $count, $categoryImageFolder)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            Log::warning("CleanDatabaseSeeder: Kategori bulunamadı ID: {$categoryId}");
            return;
        }

        $imageDirectory = storage_path('app/public/products/default/' . $categoryImageFolder);
        $availableImages = [];
        if (File::isDirectory($imageDirectory)) {
            $files = File::files($imageDirectory);
            foreach ($files as $file) {
                if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $availableImages[] = $file->getFilename();
                }
            }
        }

        if (empty($availableImages)) {
            Log::warning("CleanDatabaseSeeder: '{$categoryImageFolder}' klasöründe hiç resim bulunamadı veya klasör yok: {$imageDirectory}. Ürünler resimsiz oluşturulacak veya genel varsayılan kullanılacak.");
            // İsteğe bağlı: $defaultImagePath = 'storage/products/default/default.jpg';
        }

        for ($i = 1; $i <= $count; $i++) {
            $brand = $brands[array_rand($brands)];
            $model = $models[array_rand($models)];
            $price = rand(500, 10000);
            $stock = rand(0, 50);
            
            $productName = "{$brand} {$model} " . str_pad($i, 3, '0', STR_PAD_LEFT);
            $productSlug = Str::slug($productName);
            
            $productImagePath = null;
            if (!empty($availableImages)) {
                $selectedImage = $availableImages[array_rand($availableImages)];
                $productImagePath = 'storage/products/default/' . $categoryImageFolder . '/' . $selectedImage;
            }
            
            $product = Product::create([
                'category_id' => $categoryId,
                'name' => $productName,
                'slug' => $productSlug,
                'brand' => $brand,
                'description' => "Bu bir {$brand} {$model} {$type}. Yüksek kaliteli malzemelerden üretilmiştir.",
                'price' => $price,
                'stock' => $stock,
                'is_active' => true,
                'is_featured' => rand(0, 1) > 0.7,
                // 'image_path' alanı doğrudan Product modelinden kaldırılabilir veya null bırakılabilir,
                // çünkü artık ProductImage üzerinden yönetilecek.
            ]);
            
            if ($productImagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $productImagePath, // Fiziksel, var olan bir resim yolu
                    'is_primary' => true,
                ]);
            } else {
                Log::info("CleanDatabaseSeeder: '{$productName}' adlı ürün için '{$categoryImageFolder}' klasöründe uygun resim bulunamadı.");
            }
        }
    }
}
