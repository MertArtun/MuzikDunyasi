<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class DefaultImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createDefaultImages();
    }

    /**
     * Kategori bazlı varsayılan görseller oluştur
     */
    private function createDefaultImages(): void
    {
        $defaultImages = [
            'gitarlar' => 'https://picsum.photos/id/145/800/600',
            'piyanolar' => 'https://picsum.photos/id/164/800/600',
            'davullar' => 'https://picsum.photos/id/157/800/600',
            'yayli-calgilar' => 'https://picsum.photos/id/165/800/600',
            'uflemeli-calgilar' => 'https://picsum.photos/id/167/800/600',
            'perkusyon' => 'https://picsum.photos/id/177/800/600',
            'default' => 'https://picsum.photos/id/96/800/600',
        ];

        // Default images dizini oluştur
        $defaultDir = 'products/default';
        if (!Storage::disk('public')->exists($defaultDir)) {
            Storage::disk('public')->makeDirectory($defaultDir);
        }

        // HTTP Client
        $client = new Client(['verify' => false]);

        foreach ($defaultImages as $category => $imageUrl) {
            try {
                // İsim ve yol oluştur
                $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                $fileName = "{$category}.{$extension}";
                $path = "{$defaultDir}/{$fileName}";

                // Görsel zaten var mı kontrol et
                if (!Storage::disk('public')->exists($path)) {
                    // Görseli indir
                    $response = $client->get($imageUrl);
                    Storage::disk('public')->put($path, $response->getBody());
                    $this->command->info("Varsayılan görsel oluşturuldu: {$path}");
                } else {
                    $this->command->info("Varsayılan görsel zaten mevcut: {$path}");
                }
            } catch (\Exception $e) {
                $this->command->error("Varsayılan görsel oluşturulurken hata: {$e->getMessage()}");
            }
        }

        $this->command->info('Varsayılan görseller oluşturuldu!');
    }
} 