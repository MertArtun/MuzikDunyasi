<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'address' => 'Admin Caddesi No:1, İstanbul',
            'phone' => '5551234567',
            'balance' => 0,
            'is_active' => true,
        ]);
        
        // Create regular users
        $users = [
            [
                'name' => 'Ahmet Yılmaz',
                'email' => 'ahmet@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'address' => 'Çiçek Sokak No:15, İstanbul',
                'phone' => '5551112233',
                'balance' => 150.00,
                'is_active' => true,
            ],
            [
                'name' => 'Zeynep Kaya',
                'email' => 'zeynep@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'address' => 'Atatürk Caddesi No:42, Ankara',
                'phone' => '5552223344',
                'balance' => 75.50,
                'is_active' => true,
            ],
            [
                'name' => 'Mehmet Koç',
                'email' => 'mehmet@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'address' => 'Deniz Sokak No:8, İzmir',
                'phone' => '5553334455',
                'balance' => 200.00,
                'is_active' => true,
            ],
            [
                'name' => 'Ayşe Demir',
                'email' => 'ayse@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'address' => 'Gül Caddesi No:23, Antalya',
                'phone' => '5554445566',
                'balance' => 50.00,
                'is_active' => true,
            ],
            [
                'name' => 'Mustafa Öztürk',
                'email' => 'mustafa@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'address' => 'Park Sokak No:11, Bursa',
                'phone' => '5555556677',
                'balance' => 125.75,
                'is_active' => true,
            ],
        ];
        
        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
