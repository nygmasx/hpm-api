<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cleaning_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cleaning_station_id')->constrained('cleaning_stations')->cascadeOnDelete();
            $table->foreignId('cleaning_zone_id')->constrained('cleaning_zones')->cascadeOnDelete();
            $table->time('estimated_time');
            $table->string('products');
            $table->string('verification_type')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaning_tasks');
    }
};
