<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCategories();
        $this->importProducts();
    }

    /**
     * Kategori oluştur
     */
    private function createCategories(): void
    {
        $categories = [
            ['name' => 'Gitarlar', 'slug' => 'gitarlar', 'description' => 'Akustik, elektro ve bas gitarlar'],
            ['name' => 'Piyanolar', 'slug' => 'piyanolar', 'description' => 'Akustik ve dijital piyanolar'],
            ['name' => 'Davullar', 'slug' => 'davullar', 'description' => 'Akustik ve elektronik davul setleri'],
            ['name' => 'Yaylı Çalgılar', 'slug' => 'yayli-calgilar', 'description' => 'Keman, viyola, çello ve kontrbas'],
            ['name' => 'Üflemeli Çalgılar', 'slug' => 'uflemeli-calgilar', 'description' => 'Saksafon, flüt, klarnet ve diğer üflemeli çalgılar'],
            ['name' => 'Perküsyon', 'slug' => 'perkusyon', 'description' => 'Perküsyon ve ritim enstrümanları'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Kategoriler oluşturuldu!');
    }

    /**
     * Web'den ürünleri çek ve içe aktar
     */
    private function importProducts(): void
    {
        $this->command->info('Ürünler çekiliyor ve yükleniyor...');
        
        // Her kategoriden kaç ürün çekileceği
        $productsPerCategory = 10;
        
        $categories = Category::all();
        
        foreach ($categories as $category) {
            $this->command->info("{$category->name} kategorisinden ürünler çekiliyor...");
            
            // Kategori adına göre uygun arama terimini belirle
            $searchTerm = $this->getSearchTermForCategory($category->slug);
            
            // Ürünleri çek
            $products = $this->scrapeProducts($searchTerm, $productsPerCategory);
            
            // Çekilen ürünleri ekle
            foreach ($products as $productData) {
                try {
                    // Ürünü oluştur
                    $product = Product::updateOrCreate(
                        ['slug' => Str::slug($productData['name'])],
                        [
                            'name' => $productData['name'],
                            'description' => $productData['description'],
                            'price' => $productData['price'],
                            'stock' => rand(5, 50),
                            'is_active' => true,
                            'is_featured' => rand(0, 3) > 0 ? false : true, // %25 şansla öne çıkan ürün olsun
                            'category_id' => $category->id
                        ]
                    );
                    
                    // Ürün resmi indir ve ürüne ekle
                    if (isset($productData['image_url']) && !empty($productData['image_url'])) {
                        $this->downloadAndSaveImage($product, $productData['image_url']);
                    }
                    
                    $this->command->info("Ürün eklendi: {$productData['name']}");
                } catch (\Exception $e) {
                    $this->command->error("Ürün eklenirken hata: {$e->getMessage()}");
                }
            }
        }
        
        $this->command->info('Ürün içe aktarma tamamlandı!');
    }

    /**
     * Belirli bir kategori için arama terimini belirle
     */
    private function getSearchTermForCategory(?string $categorySlug): string
    {
        if ($categorySlug === null) {
            return 'musical instruments';
        }
        
        $searchTerms = [
            'gitarlar' => 'acoustic electric guitar',
            'piyanolar' => 'digital piano keyboard',
            'davullar' => 'drum set',
            'yayli-calgilar' => 'violin viola cello',
            'uflemeli-calgilar' => 'saxophone flute clarinet',
            'perkusyon' => 'percussion instruments cajon'
        ];
        
        return $searchTerms[$categorySlug] ?? $categorySlug;
    }

    /**
     * Ürünleri web'den çek
     */
    private function scrapeProducts(string $searchTerm, int $count = 10): array
    {
        $this->command->info("Arama terimi: $searchTerm için ürünler çekiliyor...");
        
        $products = [];
        $client = new Client(['verify' => false]); // SSL doğrulaması olmadan
        
        try {
            // Arama sayfasını çek (RapidAPI MusicStore API veya benzeri kullanılabilir)
            // Bu örnek için hayali veri oluşturacağız
            // Gerçek projede bir API kullanmalısınız
            for ($i = 0; $i < $count; $i++) {
                $productName = $this->generateProductName($searchTerm, $i);
                $products[] = [
                    'name' => $productName,
                    'description' => $this->generateDescription($productName, $searchTerm),
                    'price' => rand(500, 20000) / 1, // TL olarak fiyat
                    'image_url' => $this->getRandomImageUrl($searchTerm)
                ];
            }
            
            return $products;
        } catch (\Exception $e) {
            $this->command->error("Ürünler çekilirken hata: {$e->getMessage()}");
            return [];
        }
    }
    
    /**
     * Ürün adı oluştur
     */
    private function generateProductName(string $searchTerm, int $index): string
    {
        $brands = [
            'gitarlar' => ['Fender', 'Gibson', 'Ibanez', 'Yamaha', 'Epiphone', 'Cort', 'Martin', 'Taylor', 'PRS', 'Schecter', 'ESP', 'Gretsch'],
            'piyanolar' => ['Yamaha', 'Roland', 'Kawai', 'Casio', 'Korg', 'Nord', 'Kurzweil', 'Steinway', 'Baldwin', 'Boston'],
            'davullar' => ['Pearl', 'Tama', 'DW', 'Mapex', 'Yamaha', 'Ludwig', 'Gretsch', 'Sonor', 'Alesis', 'Roland'],
            'yayli-calgilar' => ['Stentor', 'Yamaha', 'Knilling', 'Cecilio', 'Primavera', 'D Z Strad', 'Scott Cao', 'Cremona', 'Fiddlerman'],
            'uflemeli-calgilar' => ['Yamaha', 'Selmer', 'Jupiter', 'Buffet Crampon', 'Pearl', 'Gemeinhardt', 'Conn-Selmer', 'Bach', 'Yanagisawa'],
            'perkusyon' => ['Meinl', 'Tycoon', 'LP', 'Remo', 'Pearl', 'Sabian', 'Zildjian', 'Gon Bops', 'Toca', 'Paiste']
        ];
        
        $models = [
            'gitarlar' => ['Stratocaster', 'Les Paul', 'SG', 'Telecaster', 'Dreadnought', 'Folk', 'RG Series', 'SE Custom', 'FG', 'GS', 'F-Series'],
            'piyanolar' => ['P-Series', 'FP-Series', 'ES', 'CDP', 'CTK', 'Privia', 'PSR', 'Stage', 'Artesia', 'Arius'],
            'davullar' => ['Export', 'Imperialstar', 'Collector\'s', 'Mars Series', 'Stage Custom', 'Breakbeats', 'Session', 'Armory', 'Nitro Mesh'],
            'yayli-calgilar' => ['Student', 'Professional', 'V5', 'Conservatory', 'Master', 'Concert', 'Academy', 'Advanced', 'Apprentice'],
            'uflemeli-calgilar' => ['YAS', 'Mark VI', 'JAS', 'B12', 'PF', 'Spirit', 'TR', 'YCL', 'Custom EX'],
            'perkusyon' => ['Headliner', 'Supremo', 'Aspire', 'Classic', 'Performer', 'Pro', 'A Custom', 'K Custom', 'HCS']
        ];
        
        // Arama terimine göre uygun kategoriyi belirle
        $categoryKey = $this->getCategoryKeyFromSearchTerm($searchTerm);
        
        // Rastgele marka ve model seç
        $brand = $brands[$categoryKey][array_rand($brands[$categoryKey])];
        $model = $models[$categoryKey][array_rand($models[$categoryKey])];
        
        // Rastgele bir model numarası
        $modelNumber = rand(100, 999);
        
        // Ürün adını oluştur
        return "$brand $model $modelNumber";
    }
    
    /**
     * Arama terimine göre kategori anahtarını belirle
     */
    private function getCategoryKeyFromSearchTerm(string $searchTerm): string
    {
        if (strpos($searchTerm, 'guitar') !== false) return 'gitarlar';
        if (strpos($searchTerm, 'piano') !== false) return 'piyanolar';
        if (strpos($searchTerm, 'drum') !== false) return 'davullar';
        if (strpos($searchTerm, 'violin') !== false) return 'yayli-calgilar';
        if (strpos($searchTerm, 'saxophone') !== false) return 'uflemeli-calgilar';
        if (strpos($searchTerm, 'percussion') !== false) return 'perkusyon';
        
        return 'gitarlar'; // Varsayılan olarak gitarlar
    }
    
    /**
     * Ürün açıklaması oluştur
     */
    private function generateDescription(string $productName, string $searchTerm): string
    {
        $descriptions = [
            'gitarlar' => [
                'Profesyonel müzisyenler için tasarlanmış bu gitar, mükemmel tonlaması ve kolay çalım özellikleriyle öne çıkıyor. Masif kapak, özel olarak tasarlanmış manyetikler ve üstün işçilik ile uzun ömürlü bir enstrüman.',
                'Bu enstrüman, berrak tonu ve geniş ses aralığı ile her tür müzik stiline uygun. Ergonomik tasarımı sayesinde uzun saatler boyunca rahatça çalınabilir.',
                'Yüksek kaliteli malzemelerden üretilen bu model, hem profesyonellerin hem de başlangıç seviyesindeki müzisyenlerin ihtiyaçlarına cevap verecek özelliklere sahip.',
                'Eşsiz bir ses deneyimi sunan bu enstrüman, sahne performansları ve stüdyo kayıtları için ideal. Gelişmiş elektronik bileşenler ve kaliteli tonlama sistemi içeriyor.'
            ],
            'piyanolar' => [
                'Gerçekçi piyano hissi veren ağırlıklı tuşlara sahip bu dijital piyano, 128 nota polifoni, çok sayıda farklı ses ve USB-MIDI bağlantısı sunuyor.',
                'Hem ev kullanımı hem de sahne performansları için tasarlanan bu model, zengin ses kütüphanesi ve gelişmiş ses işleme teknolojisiyle öne çıkıyor.',
                'Kompakt tasarımı ve gelişmiş özellikleriyle öne çıkan bu piyano, kulaklık çıkışı ve dahili kayıt özellikleri ile sessiz pratik yapmanıza olanak sağlar.',
                'Yüksek kaliteli hoparlör sistemi ve doğal piyano hissi veren tuş mekanizması sayesinde, akustik bir piyano deneyimini dijital olarak yaşayabilirsiniz.'
            ],
            'davullar' => [
                'Profesyonel sahne ve stüdyo kullanımı için tasarlanan bu davul seti, güçlü ve net sesler üretiyor. Dayanıklı donanım ve ayarlanabilir gerginlik sistemi ile uzun ömürlü kullanım sağlar.',
                'Kompakt boyutlarına rağmen zengin ve güçlü ses üreten bu set, hem başlangıç seviyesindeki davulcular hem de profesyoneller için uygundur.',
                'Yüksek kaliteli kaplama ve dayanıklı donanım parçalarıyla uzun ömürlü kullanım sunan bu davul seti, farklı müzik stillerine uyarlanabilir ses karakterine sahiptir.',
                'Modern ve klasik davul seslerini bir arada sunan bu elektronik davul seti, kulaklık ile sessiz pratik yapma olanağı ve USB-MIDI bağlantısı ile kayıt kolaylığı sağlar.'
            ],
            'yayli-calgilar' => [
                'El yapımı bu enstrüman, sıcak ve zengin tonlamasıyla öne çıkıyor. Kaliteli ahşaptan üretilen gövdesi, dayanıklılık ve optimum ses kalitesi sunuyor.',
                'Başlangıç seviyesinden profesyonel seviyeye kadar her müzisyen için uygun olan bu model, zengin tonlaması ve uygun fiyatıyla dikkat çekiyor.',
                'Geleneksel yapım teknikleri kullanılarak üretilen bu enstrüman, dengeli ses dağılımı ve kolay çalım özellikleriyle her seviyeden müzisyene hitap ediyor.',
                'Modern tasarım ve klasik tonlamayı bir arada sunan bu model, konservatuar öğrencileri ve profesyonel müzisyenler için idealdir.'
            ],
            'uflemeli-calgilar' => [
                'Hassas işçiliği ve zengin sesiyle öne çıkan bu enstrüman, hem solo performanslar hem de orkestra çalışmaları için mükemmel bir seçimdir.',
                'Profesyonel müzisyenler için tasarlanan bu model, yüksek kaliteli malzemeler ve hassas mekanik sistemiyle üstün performans sunar.',
                'Başlangıç seviyesindeki müzisyenler için ideal olan bu enstrüman, kolay üfleme ve doğru ton üretme özellikleriyle öğrenme sürecini kolaylaştırır.',
                'Dayanıklı yapısı ve zengin ses tonlamasıyla uzun yıllar boyunca profesyonel kullanım için tasarlanan üstün kaliteli bir enstrüman.'
            ],
            'perkusyon' => [
                'El yapımı bu perküsyon aleti, doğal ve zengin sesler üreterek hem solo performanslar hem de grup çalışmaları için idealdir.',
                'Kompakt boyutu ve güçlü ses üretme kapasitesiyle her türlü müzik tarzına uyum sağlayan çok yönlü bir ritim enstrümanıdır.',
                'Geleneksel yapım teknikleri ile üretilen bu model, otantik sesler arayanlar için mükemmel bir seçimdir.',
                'Modern tasarım ve geleneksel sesleri bir araya getiren bu perküsyon aleti, stüdyo kayıtları ve sahne performansları için optimum kalite sunar.'
            ]
        ];
        
        $categoryKey = $this->getCategoryKeyFromSearchTerm($searchTerm);
        $categoryDescriptions = $descriptions[$categoryKey] ?? $descriptions['gitarlar'];
        
        $description = $categoryDescriptions[array_rand($categoryDescriptions)];
        
        // Ürün adını açıklamaya ekle
        $fullDescription = "$productName - $description\n\n";
        
        // Teknik özellikler ekle
        $fullDescription .= "Teknik Özellikler:\n";
        
        switch ($categoryKey) {
            case 'gitarlar':
                $fullDescription .= "• Gövde Malzemesi: " . ['Maun', 'Akçaağaç', 'Kül', 'Okoume', 'Kavak', 'Ceviz'][array_rand(['Maun', 'Akçaağaç', 'Kül', 'Okoume', 'Kavak', 'Ceviz'])] . "\n";
                $fullDescription .= "• Klavye: " . ['Abanoz', 'Akçaağaç', 'Gülağacı', 'Pelesenk'][array_rand(['Abanoz', 'Akçaağaç', 'Gülağacı', 'Pelesenk'])] . "\n";
                $fullDescription .= "• Manyetikler: " . ['Humbucker', 'Single Coil', 'P90', 'Aktif', 'Pasif'][array_rand(['Humbucker', 'Single Coil', 'P90', 'Aktif', 'Pasif'])] . "\n";
                $fullDescription .= "• Köprü: " . ['Tune-O-Matic', 'Tremolo', 'Hardtail', 'Floyd Rose', 'String-Through-Body'][array_rand(['Tune-O-Matic', 'Tremolo', 'Hardtail', 'Floyd Rose', 'String-Through-Body'])] . "\n";
                $fullDescription .= "• Perde Sayısı: " . [21, 22, 24][array_rand([21, 22, 24])] . "\n";
                break;
                
            case 'piyanolar':
                $fullDescription .= "• Tuş Sayısı: " . [61, 76, 88][array_rand([61, 76, 88])] . "\n";
                $fullDescription .= "• Polifoni: " . [64, 128, 192, 256][array_rand([64, 128, 192, 256])] . " nota\n";
                $fullDescription .= "• Ses Sayısı: " . [10, 20, 40, 60, 100, 200][array_rand([10, 20, 40, 60, 100, 200])] . "\n";
                $fullDescription .= "• Bağlantılar: USB, MIDI, Aux in/out, Kulaklık\n";
                $fullDescription .= "• Boyutlar (GxDxY): " . rand(120, 150) . "x" . rand(30, 50) . "x" . rand(10, 20) . " cm\n";
                break;
                
            case 'davullar':
                $fullDescription .= "• Parça Sayısı: " . [4, 5, 6, 7][array_rand([4, 5, 6, 7])] . " parça\n";
                $fullDescription .= "• Büyük Davul: " . [20, 22, 24][array_rand([20, 22, 24])] . " inç\n";
                $fullDescription .= "• Trampet: " . [13, 14][array_rand([13, 14])] . " inç\n";
                $fullDescription .= "• Tom Tom: " . [10, 12, 14][array_rand([10, 12, 14])] . " inç ve " . [12, 14, 16][array_rand([12, 14, 16])] . " inç\n";
                $fullDescription .= "• Ziller: Hi-hat, Crash, Ride\n";
                break;
                
            case 'yayli-calgilar':
                $fullDescription .= "• Gövde Malzemesi: " . ['Ladin', 'Akçaağaç', 'Küknar'][array_rand(['Ladin', 'Akçaağaç', 'Küknar'])] . "\n";
                $fullDescription .= "• Tuşe: " . ['Abanoz', 'Akçaağaç', 'Pelesenk'][array_rand(['Abanoz', 'Akçaağaç', 'Pelesenk'])] . "\n";
                $fullDescription .= "• Boyut: " . ['4/4', '3/4', '1/2', '1/4'][array_rand(['4/4', '3/4', '1/2', '1/4'])] . "\n";
                $fullDescription .= "• Yay: " . ['Brezilya Ahşabı', 'Karbon Fiber', 'Fiberglass'][array_rand(['Brezilya Ahşabı', 'Karbon Fiber', 'Fiberglass'])] . "\n";
                $fullDescription .= "• Set İçeriği: Enstrüman, Yay, Çanta, Reçine\n";
                break;
                
            case 'uflemeli-calgilar':
                $fullDescription .= "• Malzeme: " . ['Pirinç', 'Gümüş Kaplama', 'Nikel', 'ABS Reçine'][array_rand(['Pirinç', 'Gümüş Kaplama', 'Nikel', 'ABS Reçine'])] . "\n";
                $fullDescription .= "• Tuş Sistemi: " . ['Boehm', 'Albert', 'Konservatuar'][array_rand(['Boehm', 'Albert', 'Konservatuar'])] . "\n";
                $fullDescription .= "• Perdeler: Yüksek kalite paslanmaz çelik\n";
                $fullDescription .= "• Ağızlık: " . ['Dahil', 'Profesyonel Tip', 'Yükseltilmiş Model'][array_rand(['Dahil', 'Profesyonel Tip', 'Yükseltilmiş Model'])] . "\n";
                $fullDescription .= "• Set İçeriği: Enstrüman, Çanta, Temizlik Kiti\n";
                break;
                
            case 'perkusyon':
                $fullDescription .= "• Malzeme: " . ['Maun', 'Akçaağaç', 'Meşe', 'Kavak', 'Birch'][array_rand(['Maun', 'Akçaağaç', 'Meşe', 'Kavak', 'Birch'])] . "\n";
                $fullDescription .= "• Boyutlar: " . rand(20, 50) . "x" . rand(20, 40) . "x" . rand(20, 40) . " cm\n";
                $fullDescription .= "• Ağırlık: " . rand(1, 10) . "." . rand(0, 9) . " kg\n";
                $fullDescription .= "• Yüzey: " . ['Doğal', 'Cilalı', 'Mat', 'Vernikli'][array_rand(['Doğal', 'Cilalı', 'Mat', 'Vernikli'])] . "\n";
                $fullDescription .= "• Set İçeriği: " . ['Enstrüman, Çanta', 'Enstrüman, Çanta, Ekstra Parçalar', 'Enstrüman, Ayaklık'][array_rand(['Enstrüman, Çanta', 'Enstrüman, Çanta, Ekstra Parçalar', 'Enstrüman, Ayaklık'])] . "\n";
                break;
        }
        
        return $fullDescription;
    }
    
    /**
     * Ürün fotoğrafı için rastgele URL oluştur
     */
    private function getRandomImageUrl(string $searchTerm): string
    {
        // Kategori bazlı görsel URL'leri - daha güvenilir ve çalışan URL'ler
        $categoryKey = $this->getCategoryKeyFromSearchTerm($searchTerm);
        
        // Her kategori için farklı görsel URL'leri
        $imageUrls = [
            'gitarlar' => [
                'https://picsum.photos/id/145/800/600', // Gitar
                'https://picsum.photos/id/977/800/600', // Gitar
                'https://picsum.photos/id/96/800/600',  // Gitar
                'https://picsum.photos/id/175/800/600', // Gitar
                'https://loremflickr.com/800/600/guitar',
                'https://loremflickr.com/800/600/electric,guitar',
                'https://loremflickr.com/800/600/bass,guitar',
                'https://loremflickr.com/800/600/acoustic,guitar'
            ],
            'piyanolar' => [
                'https://picsum.photos/id/164/800/600', // Piyano
                'https://picsum.photos/id/160/800/600', // Piyano
                'https://loremflickr.com/800/600/piano',
                'https://loremflickr.com/800/600/keyboard,piano',
                'https://loremflickr.com/800/600/digital,piano',
                'https://loremflickr.com/800/600/grand,piano'
            ],
            'davullar' => [
                'https://picsum.photos/id/157/800/600', // Müzik
                'https://loremflickr.com/800/600/drums',
                'https://loremflickr.com/800/600/drum,set',
                'https://loremflickr.com/800/600/electronic,drums'
            ],
            'yayli-calgilar' => [
                'https://picsum.photos/id/165/800/600', // Müzik
                'https://loremflickr.com/800/600/violin',
                'https://loremflickr.com/800/600/viola',
                'https://loremflickr.com/800/600/cello'
            ],
            'uflemeli-calgilar' => [
                'https://picsum.photos/id/167/800/600', // Müzik
                'https://loremflickr.com/800/600/saxophone',
                'https://loremflickr.com/800/600/trumpet',
                'https://loremflickr.com/800/600/flute'
            ],
            'perkusyon' => [
                'https://picsum.photos/id/177/800/600', // Müzik
                'https://loremflickr.com/800/600/percussion',
                'https://loremflickr.com/800/600/djembe',
                'https://loremflickr.com/800/600/cajon'
            ]
        ];
        
        // Kategori URL'leri yoksa varsayılan URL'leri kullan
        $urls = $imageUrls[$categoryKey] ?? $imageUrls['gitarlar'];
        
        // Rastgele bir URL seç
        return $urls[array_rand($urls)];
    }
    
    /**
     * Resmi indir ve ürüne ekle
     */
    private function downloadAndSaveImage(Product $product, string $imageUrl): void
    {
        try {
            // Clean URL parameters if they exist
            $imageUrl = strtok($imageUrl, '?');
            
            // Get file extension from URL
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            
            // Create unique file name
            $imageName = Str::slug($product->name) . '-' . uniqid() . '.' . $extension;
            $savePath = 'products/' . $imageName;
            
            // Download image with timeout and retry logic
            $client = new Client([
                'verify' => false,
                'timeout' => 10,
                'connect_timeout' => 5
            ]);
            
            $maxRetries = 3;
            $retries = 0;
            $success = false;
            
            while (!$success && $retries < $maxRetries) {
                try {
                    $response = $client->get($imageUrl);
                    if ($response->getStatusCode() === 200) {
                        $success = true;
                        
                        // Save image to storage disk
                        Storage::disk('public')->put($savePath, $response->getBody());
                        
                        // Update product image path
                        $product->image_path = $savePath;
                        $product->save();
                        
                        // Ayrıca ProductImage tablosuna da ekle
                        $productImage = ProductImage::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'is_primary' => true
                            ],
                            [
                                'image_path' => $savePath
                            ]
                        );
                        
                        // Önceki primary_image'ları false yap
                        ProductImage::where('product_id', $product->id)
                            ->where('id', '!=', $productImage->id)
                            ->update(['is_primary' => false]);
                        
                        $this->command->info("Ürün görseli kaydedildi: {$savePath}");
                    }
                } catch (\Exception $e) {
                    $retries++;
                    $this->command->warn("Görsel indirme hatası, yeniden deneniyor ({$retries}/{$maxRetries}): {$e->getMessage()}");
                    sleep(1); // Kısa bir bekleme ile yeniden dene
                }
            }
            
            // Yine de indirilemedi ise varsayılan görsel kullan
            if (!$success) {
                // Kategori bazlı varsayılan görsel
                $categorySlug = $product->category->slug ?? 'default';
                $defaultImage = "products/default/{$categorySlug}.jpg";
                
                // Varsayılan görsel yoksa genel varsayılan kullan
                if (!Storage::disk('public')->exists($defaultImage)) {
                    $defaultImage = "products/default/default.jpg";
                }
                
                // Varsayılan görsel mevcut ise kullan
                if (Storage::disk('public')->exists($defaultImage)) {
                    $product->image_path = $defaultImage;
                    $product->save();
                    
                    ProductImage::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'is_primary' => true
                        ],
                        [
                            'image_path' => $defaultImage
                        ]
                    );
                    
                    $this->command->info("Ürün için varsayılan görsel kullanıldı: {$defaultImage}");
                } else {
                    $this->command->error("Ürün için görsel indirilemedi ve varsayılan görsel bulunamadı: {$product->name}");
                }
            }
        } catch (\Exception $e) {
            $this->command->error("Resim indirilirken hata: {$e->getMessage()}");
        }
    }
}
