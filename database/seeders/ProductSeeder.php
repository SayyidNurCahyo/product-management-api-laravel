<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'product_category_id' => 2, // Electronics category ID (assuming first category)
                'name' => 'Drawing Book',
                'price' => 1000,
                'quantity' => 100,
                'image' => 'drawing-book.jpg', // Assuming you have an image file named 'laptop.jpg'
            ],
            [
                'product_category_id' => 1, // Clothing category ID (assuming second category)
                'name' => 'T-Shirt',
                'price' => 20000,
                'quantity' => 50,
                'image' => 'tshirt.jpg', // Assuming you have an image file named 'tshirt.jpg'
            ],
            // Add more product data as needed
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
