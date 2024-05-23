<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Apparel'],
            ['name' => 'Electronics'],
            ['name' => 'Beauty & Personal Care'],
            ['name' => 'Home & Kitchen'],
            ['name' => 'Sports & Outdoors'],
        ]);

        $categories->each(fn ($category) => Category::factory()->create($category));

        $childCategories = collect([
            // Apparel
            ['parent_id' => 1,'name' => 'Tops'],
            ['parent_id' => 1,'name' => 'Bottoms'],
            ['parent_id' => 1,'name' => 'Dresses'],
            ['parent_id' => 1,'name' => 'Outerwear'],
            ['parent_id' => 1,'name' => 'Active wear'],
            ['parent_id' => 1,'name' => 'Sleepwear'],
            ['parent_id' => 1,'name' => 'Swimwear'],
            ['parent_id' => 1,'name' => 'Accessories'],

            // Electronics
            ['parent_id' => 2,'name' => 'Mobile Phones'],
            ['parent_id' => 2,'name' => 'Laptops & Computers'],
            ['parent_id' => 2,'name' => 'Tablets & E-readers'],
            ['parent_id' => 2,'name' => 'TVs & Home Entertainment'],
            ['parent_id' => 2,'name' => 'Cameras & Photography'],
            ['parent_id' => 2,'name' => 'Audio & Headphones'],
            ['parent_id' => 2,'name' => 'Wearable Technology'],
            ['parent_id' => 2,'name' => 'Gaming Consoles & Accessories'],

            // Beauty & Personal Care
            ['parent_id' => 3,'name' => 'Skincare'],
            ['parent_id' => 3,'name' => 'Makeup'],
            ['parent_id' => 3,'name' => 'Haircare'],
            ['parent_id' => 3,'name' => 'Fragrances'],
            ['parent_id' => 3,'name' => 'Bath & Body'],
            ['parent_id' => 3,'name' => "Men's Grooming"],
            ['parent_id' => 3,'name' => 'Oral Care'],
            ['parent_id' => 3,'name' => 'Beauty Tools & Accessories'],

            // Home & Kitchen
            ['parent_id' => 4,'name' => 'Furniture'],
            ['parent_id' => 4,'name' => 'Kitchen Appliances'],
            ['parent_id' => 4,'name' => 'Cookware & Bakeware'],
            ['parent_id' => 4,'name' => 'Home Décor'],
            ['parent_id' => 4,'name' => 'Bedding & Linens'],
            ['parent_id' => 4,'name' => 'Storage & Organization'],
            ['parent_id' => 4,'name' => 'Cleaning Supplies'],
            ['parent_id' => 4,'name' => 'Outdoor Living'],

            // Sports & Outdoors
            ['parent_id' => 5,'name' => 'Exercise & Fitness Equipment'],
            ['parent_id' => 5,'name' => 'Activewear & Sports Clothing'],
            ['parent_id' => 5,'name' => 'Footwear'],
            ['parent_id' => 5,'name' => 'Outdoor Recreation'],
            ['parent_id' => 5,'name' => 'Team Sports'],
            ['parent_id' => 5,'name' => 'Water Sports'],
            ['parent_id' => 5,'name' => 'Cycling & Bike Accessories'],
            ['parent_id' => 5,'name' => 'Hunting & Fishing Gear'],
        ]);

        $childCategories = $childCategories->shuffle();

        $childCategories->each(fn ($childCategory) => Category::factory()->create($childCategory));
    }
}
