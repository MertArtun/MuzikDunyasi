<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gitarlar',
                'description' => 'Akustik, elektro ve bas gitarlar',
                'parent_id' => null,
                'subcategories' => [
                    [
                        'name' => 'Akustik Gitarlar',
                        'description' => 'Klasik ve Western akustik gitarlar',
                    ],
                    [
                        'name' => 'Elektro Gitarlar',
                        'description' => 'Her türlü elektro gitarlar',
                    ],
                    [
                        'name' => 'Bas Gitarlar',
                        'description' => 'Akustik ve elektrikli bas gitarlar',
                    ],
                ],
            ],
            [
                'name' => 'Piyanolar & Klavyeler',
                'description' => 'Akustik ve dijital piyanolar, synthesizer ve klavyeler',
                'parent_id' => null,
                'subcategories' => [
                    [
                        'name' => 'Akustik Piyanolar',
                        'description' => 'Kuyruklu ve duvar tipi akustik piyanolar',
                    ],
                    [
                        'name' => 'Dijital Piyanolar',
                        'description' => 'Dijital ve stage piyanolar',
                    ],
                    [
                        'name' => 'Synthesizer & Workstation',
                        'description' => 'Synthesizer, workstation ve MIDI klavyeler',
                    ],
                ],
            ],
            [
                'name' => 'Yaylı Çalgılar',
                'description' => 'Keman, viyola, çello ve kontrbas',
                'parent_id' => null,
                'subcategories' => [
                    [
                        'name' => 'Kemanlar',
                        'description' => 'Klasik ve elektro kemanlar',
                    ],
                    [
                        'name' => 'Viyola & Çello',
                        'description' => 'Viyola ve çello çeşitleri',
                    ],
                ],
            ],
            [
                'name' => 'Davul & Perküsyon',
                'description' => 'Akustik davullar, elektronik davullar ve perküsyon aletleri',
                'parent_id' => null,
                'subcategories' => [
                    [
                        'name' => 'Akustik Davullar',
                        'description' => 'Akustik davul setleri ve parçaları',
                    ],
                    [
                        'name' => 'Elektronik Davullar',
                        'description' => 'Elektronik davul setleri ve parçaları',
                    ],
                    [
                        'name' => 'Perküsyon Aletleri',
                        'description' => 'Darbuka, def, cajon ve diğer perküsyon aletleri',
                    ],
                ],
            ],
            [
                'name' => 'Nefesli Çalgılar',
                'description' => 'Tahta ve bakır üflemeli çalgılar',
                'parent_id' => null,
                'subcategories' => [
                    [
                        'name' => 'Flüt & Piccolo',
                        'description' => 'Flüt ve piccolo çeşitleri',
                    ],
                    [
                        'name' => 'Klarnet & Saksafon',
                        'description' => 'Klarnet ve saksafon çeşitleri',
                    ],
                    [
                        'name' => 'Trompet & Trombon',
                        'description' => 'Trompet, trombon ve diğer bakır üflemeliler',
                    ],
                ],
            ],
            [
                'name' => 'Ses & Kayıt Ekipmanları',
                'description' => 'Mikrofon, amfi, mixer ve diğer ses ekipmanları',
                'parent_id' => null,
                'subcategories' => [
                    [
                        'name' => 'Mikrofonlar',
                        'description' => 'Dinamik, kondenser ve diğer mikrofon çeşitleri',
                    ],
                    [
                        'name' => 'Amfiler & Efekt Pedalları',
                        'description' => 'Gitar ve bas amfileri, efekt pedalları',
                    ],
                    [
                        'name' => 'Mixer & Ses Kartları',
                        'description' => 'Ses mikserleri, ses kartları ve ses kayıt ekipmanları',
                    ],
                ],
            ],
        ];
        
        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'] ?? [];
            unset($categoryData['subcategories']);
            
            $category = Category::create($categoryData);
            
            foreach ($subcategories as $subcategoryData) {
                $subcategoryData['parent_id'] = $category->id;
                Category::create($subcategoryData);
            }
        }
    }
}
