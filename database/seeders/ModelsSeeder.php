<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            ['name' => 'Corolla', 'brand_id' => 1, 'startYear' => 2020, 'endYear' => 2024, 'image_start_year' => 'toyota-corolla-2020.jpeg', 'image_end_year' => 'toyota-corolla-2024.jpeg'],
            ['name' => 'Camry', 'brand_id' => 1, 'startYear' => 2018, 'endYear' => 2023, 'image_start_year' => 'toyota-camry-2018.jpeg', 'image_end_year' => 'toyota-camry-2023.jpeg'],
            ['name' => 'Civic', 'brand_id' => 2, 'startYear' => 2019, 'endYear' => 2024, 'image_start_year' => 'honda-civic-2019.jpeg', 'image_end_year' => 'honda-civic-2024.jpeg'],
            ['name' => 'Accord', 'brand_id' => 2, 'startYear' => 2017, 'endYear' => 2022, 'image_start_year' => 'honda-accord-2017.jpeg', 'image_end_year' => 'honda-accord-2022.jpeg'],
            ['name' => 'Mustang', 'brand_id' => 3, 'startYear' => 2016, 'endYear' => 2023, 'image_start_year' => 'ford-mustang-2016.jpeg', 'image_end_year' => 'ford-mustang-2023.jpeg'],
            ['name' => 'F-150', 'brand_id' => 3, 'startYear' => 2015, 'endYear' => 2024, 'image_start_year' => 'ford-f150-2015.jpeg', 'image_end_year' => 'ford-f150-2024.jpg'],
            ['name' => 'X5', 'brand_id' => 4, 'startYear' => 2019, 'endYear' => 2024, 'image_start_year' => 'bmw-x5-2019.jpeg', 'image_end_year' => 'bmw-x5-2024.jpg'],
            ['name' => 'C-Class', 'brand_id' => 5, 'startYear' => 2020, 'endYear' => 2023, 'image_start_year' => 'mercedes-c-class-2020.jpeg', 'image_end_year' => 'mercedes-c-class-2023.jpeg'],
        ];

        foreach ($models as $model)
        {

            DB::table('models')->insert([
                'name' => $model['name'],
                'brand_id' => $model['brand_id'],
                'startYear' => $model['startYear'],
                'endYear' => $model['endYear'],
                'image_start_year' => $model['image_start_year'],
                'image_end_year' => $model['image_end_year'],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
