<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('admin1234'),
        //     'mobile'=>'01066056969',
        //     'role' => 'admin',
        // ]);

        // User::create([
        //     'name' => 'Employee User',
        //     'email' => 'employee@example.com',
        //     'password' => bcrypt('employee1234'),
        //     'mobile'=>'01066056968',
        //     'role' => 'employee',
        // ]);
        // User::create([
        //     'name' => 'Delivery User',
        //     'email' => 'Delivery@example.com',
        //     'password' => bcrypt('delivery1234'),
        //     'mobile'=>'01066056970',
        //     'role' => 'delivery',
        // ]);
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'mobile'=>'01066056969',
            'password' => Hash::make('delivery1234'),
            'role' => 'admin',
        ]);
    
        User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'mobile'=>'01066056968',
            'password' => Hash::make('delivery1234'),
            'role' => 'employee',
        ]);
    
        User::create([
            'name' => 'Delivery User',
            'email' => 'delivery@example.com',
            'mobile'=>'01066056970',
            'password' => Hash::make('delivery1234'),
            'role' => 'delivery',
        ]);
    }
}
