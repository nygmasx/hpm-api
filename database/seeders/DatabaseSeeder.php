<?php

namespace Database\Seeders;

use App\Models\CleaningStation;
use App\Models\CleaningZone;
use App\Models\Equipment;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductTracability;
use App\Models\StripeProduct;
use App\Models\Supplier;
use App\Models\Tracability;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\SupplierFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('tracabilities')->delete();
        DB::table('users')->delete();

        User::factory()->create([
            "email" => "admin@admin.com",
            "name" => "Admin",
            "role" => "admin",
        ]);
        Product::factory(15)->create();
        Image::factory(5)->create();
        Tracability::factory(5)->create();
        Equipment::factory(10)->create();
        Supplier::factory(10)->create();
        StripeProduct::factory(2)->sequence(
            [
                'name' => 'Offre Basique',
                'stripe_product_id' => 'prod_RLNj51g7mwTWJj',
                'price' => 9.99,
            ],
            [
                'name' => 'Offre Premium',
                'stripe_product_id' => 'prod_RLNs0sCjYzO8Mm',
                'price' => 19.99,
            ],
        )->create();
    }
}
