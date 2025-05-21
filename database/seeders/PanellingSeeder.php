<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PanellingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'تلبيسة الليزر - بني مطرز بني',
                'link' => 'https://www.bleco.sa/products/laser-brown',
                'description' => 'تلبيسة الليزر بني مطرز بني لتوفير حماية وأناقة لمقصورة سيارتك.',
                'category_id' => 13,
                'status' => 1,
                'image' => '06_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الليزر - بيج مطرز بيج',
                'link' => 'https://www.bleco.sa/products/laser-beige',
                'description' => 'تلبيسة الليزر بيج مطرز بيج لجودة وأداء مميز.',
                'category_id' => 13,
                'status' => 1,
                'image' => '7ecf33c2b2946b0363021f3f5d1e5767_10b3a1d1-7139-46b4-b1bc-3f156c69fac5_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الفاخر - عنابي مطرز عنابي',
                'link' => 'https://www.bleco.sa/products/luxury-maroon',
                'description' => 'تلبيسة الفاخر عنابي مطرز عنابي لمنح السيارة مظهرًا فاخرًا.',
                'category_id' => 14,
                'status' => 1,
                'image' => '10-9_001_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الدايموند - رصاصي مطرز بيج',
                'link' => 'https://www.bleco.sa/products/diamond-gray-beige',
                'description' => 'تلبيسة الدايموند رصاصي مطرز بيج بتصميم أنيق ومتين.',
                'category_id' => 15,
                'status' => 1,
                'image' => '8805pu-bk-f-1_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الدايموند - بني مطرز بني',
                'link' => 'https://www.bleco.sa/products/diamond-brown',
                'description' => 'تلبيسة الدايموند بني مطرز بني توفر لمسة فريدة من الفخامة.',
                'category_id' => 15,
                'status' => 1,
                'image' => '8839-rd-f-m_1_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة المثلثات - بيج مطرز بيج',
                'link' => 'https://www.bleco.sa/products/triangles-beige',
                'description' => 'تلبيسة المثلثات بيج مطرز بيج مصممة لحماية مقاعد السيارة من التآكل.',
                'category_id' => 16,
                'status' => 1,
                'image' => 'GR01_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الليزر - أسود مطرز أسود',
                'link' => 'https://www.bleco.sa/products/laser-black',
                'description' => 'تلبيسة الليزر أسود مطرز أسود تمنح مقاعد سيارتك مظهرًا أنيقًا وعصريًا.',
                'category_id' => 13,
                'status' => 1,
                'image' => 'gr003_521be79a-f2ab-4410-bb1e-7d18dee7686d_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الفاخر - بيج مطرز بيج',
                'link' => 'https://www.bleco.sa/products/luxury-beige',
                'description' => 'تلبيسة الفاخر بيج مطرز بيج تضيف مزيدًا من الأناقة لسيارتك.',
                'category_id' => 14,
                'status' => 1,
                'image' => 'scu010-front-red_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الدايموند - جملي مطرز جملي',
                'link' => 'https://www.bleco.sa/products/diamond-camel',
                'description' => 'تلبيسة الدايموند جملي مطرز جملي مصنوعة من خامات عالية الجودة.',
                'category_id' => 15,
                'status' => 1,
                'image' => 'UniversalCompatibleSeatCoverFitCarRed1_270x270.avif',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'تلبيسة الفاخر - أسود مطرز أسود',
                'link' => 'https://www.bleco.sa/products/luxury-black',
                'description' => 'تلبيسة الفاخر أسود مطرز أسود بتصميم حديث وأنيق.',
                'category_id' => 14,
                'status' => 1,
                'image' => 'UniversalWaterproofSeatCoverFitCarBrown1_270x270.avif',
                'created_at' => Carbon::now(),
            ],
        ];

        // Insert products into the database
        DB::table('panelings')->insert($products);
    }
}


