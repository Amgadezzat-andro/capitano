<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'ليزر',
                'image' => 'laser.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1,
            ],
            [
                'name' => 'دايموند',
                'image' => 'diamond.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1,
            ],
            [
                'name' => 'مثلثات',
                'image' => 'triangles.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1,
            ],
            [
                'name' => 'فاخر',
                'image' => 'luxury.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1,
            ],
        ]);
    }
}
