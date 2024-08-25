<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductTracability;
use App\Models\Tracability;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ]);
        Product::factory(15)->create();
        Image::factory(5)->create();
        Tracability::factory(5)->create();
        Equipment::factory(10)->create();
    }
}
