<?php

namespace Database\Seeders;

use App\Models\CleaningStation;
use App\Models\CleaningTask;
use App\Models\CleaningZone;
use App\Models\Equipment;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductTracability;
use App\Models\StripeProduct;
use App\Models\Supplier;
use App\Models\Tracability;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('tracabilities')->delete();
        DB::table('users')->delete();
        DB::table('users_cleaning_zones')->delete();
        DB::table('users_cleaning_tasks')->delete();
        DB::table('cleaning_tasks')->delete();
        DB::table('cleaning_stations')->delete();
        DB::table('cleaning_zones')->delete();

        // Create admin user
        $admin = User::factory()->create([
            "email" => "admin@admin.com",
            "name" => "Admin",
            "role" => "admin",
        ]);

        // Create regular users
        $users = User::factory(5)->create();

        // Create cleaning zones
        $zones = CleaningZone::factory(4)->create();

        // Create cleaning stations for each zone
        $stations = [];
        foreach ($zones as $zone) {
            // Create 2-3 stations per zone
            $zoneStations = CleaningStation::factory(rand(2, 3))->create([
                'cleaning_zone_id' => $zone->id
            ]);
            $stations = array_merge($stations, $zoneStations->all());
        }

        // Create cleaning tasks for stations
        $tasks = [];
        foreach ($stations as $station) {
            // Create 2-4 tasks per station
            $stationTasks = CleaningTask::factory(rand(2, 4))->create([
                'cleaning_station_id' => $station->id
            ]);
            $tasks = array_merge($tasks, $stationTasks->all());
        }

        // Get all users
        $allUsers = User::all();

        // Assign all zones to all users
        $allUsers->each(function ($user) use ($zones) {
            $zones->each(function ($zone) use ($user) {
                DB::table('users_cleaning_zones')->insert([
                    'user_id' => $user->id,
                    'cleaning_zone_id' => $zone->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        // Assign all tasks to all users
        $allUsers->each(function ($user) use ($tasks) {
            collect($tasks)->each(function ($task) use ($user) {
                DB::table('users_cleaning_tasks')->insert([
                    'user_id' => $user->id,
                    'cleaning_task_id' => $task->id,
                    'is_completed' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        // Create other data
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
