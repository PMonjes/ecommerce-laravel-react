<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::where('slug', 'poleras')->first();

        $items = [
            ['Polera Básica Negra', 9990, 50],
            ['Polera Oversize Blanca', 12990, 30],
            ['Polera Deportiva', 14990, 20],
        ];

        foreach ($items as [$name, $price, $stock]) {
            Product::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => $cat?->id,
                    'name' => $name,
                    'price_cents' => $price * 100, // ojo: price en CLP -> si quieres en pesos, usa directo sin *100
                    'stock' => $stock,
                    'is_active' => true,
                    'description' => 'Producto de prueba',
                    'sort_order' => 0,
                ]
            );
        }
    }
}