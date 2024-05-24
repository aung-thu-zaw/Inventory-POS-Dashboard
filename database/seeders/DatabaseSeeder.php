<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            WarrantySeeder::class,
            CountrySeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            WarehouseSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class
        ]);
    }
}
