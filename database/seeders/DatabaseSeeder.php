<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@jagatnusantara.test'],
            [
                'full_name' => 'Admin Jagat Nusantara',
                'phone' => '081234567890',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Sample customer
        User::updateOrCreate(
            ['email' => 'customer@jagatnusantara.test'],
            [
                'full_name' => 'Budi Pelanggan',
                'phone' => '081298765432',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
            ]
        );

        // Categories & Products
        $data = [
            'Beras' => [
                'Premium' => [
                    ['name' => 'Idola', 'variants' => [25], 'price_per_kg' => 16000],
                ],
                'Medium' => [
                    ['name' => 'Rojo Lele', 'variants' => [5, 10, 25], 'price_per_kg' => 13500],
                    ['name' => 'Ramos Bandung', 'variants' => [5, 10, 25], 'price_per_kg' => 13000],
                    ['name' => 'SPHP', 'variants' => [5], 'price_per_kg' => 11000],
                ],
            ],
            'Minyak Goreng' => [
                'Minyakita' => [
                    ['name' => 'Minyakita', 'variants' => [1, 2], 'price_per_kg' => 15000],
                ],
            ],
        ];

        foreach ($data as $catName => $subCats) {
            $cat = Category::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName)]
            );

            foreach ($subCats as $subName => $products) {
                $sub = SubCategory::firstOrCreate(
                    ['category_id' => $cat->id, 'name' => $subName],
                    ['slug' => Str::slug($catName . '-' . $subName)]
                );

                foreach ($products as $product) {
                    foreach ($product['variants'] as $kg) {
                        $name = $product['name'] . ' ' . $kg . 'L';
                        if ($catName === 'Beras') {
                            $name = $product['name'] . ' ' . $kg . 'kg';
                        }
                        $price = $kg * $product['price_per_kg'];

                        Product::firstOrCreate(
                            ['name' => $name],
                            [
                                'sub_category_id' => $sub->id,
                                'slug' => Str::slug($name) . '-' . uniqid(),
                                'description' => "{$product['name']} kemasan {$kg}" . ($catName === 'Beras' ? 'kg' : 'L') . ". Kualitas {$subName} pilihan terbaik.",
                                'price' => $price,
                                'weight_label' => $kg . ($catName === 'Beras' ? 'kg' : 'L'),
                                'stock' => 50,
                                'is_active' => true,
                            ]
                        );
                    }
                }
            }
        }

        $this->command->info('Seed selesai!');
        $this->command->info('Login admin   : admin@jagatnusantara.test / admin123');
        $this->command->info('Login customer: customer@jagatnusantara.test / customer123');
    }
}