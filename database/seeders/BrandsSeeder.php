<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Toyota', 'image' => 'toyota.png'],
            ['name' => 'Honda', 'image' => 'honda.png'],
            ['name' => 'Ford', 'image' => 'ford.png'],
            ['name' => 'Chevrolet', 'image' => 'chevrolet.png'],
            ['name' => 'BMW', 'image' => 'bmw.png'],
            ['name' => 'Mercedes-Benz', 'image' => 'mercedes.png'],
            ['name' => 'Audi', 'image' => 'audi.png'],
            ['name' => 'Nissan', 'image' => 'nissan.png'],
            ['name' => 'Hyundai', 'image' => 'hyundai.png'],
            ['name' => 'Kia', 'image' => 'kia.png'],
            ['name' => 'Volkswagen', 'image' => 'volkswagen.png'],
        ];

        foreach ($brands as $brand)
        {
            DB::table('brands')->insert([
                'name'=>$brand['name'],
                'image'=>$brand['image'],
                'status' => 1, // Active
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
