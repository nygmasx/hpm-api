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
            $table->string('title');
            $table->string('estimated_time');
            $table->string('products');
            $table->string('products_quantity')->nullable();
            $table->string('verification_type');
            $table->string('temperature')->nullable();
            $table->string('action_time')->nullable();
            $table->string('utensil')->nullable();
            $table->string('rinse_type')->nullable();
            $table->string('drying_type')->nullable();
            $table->string('frequency');
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
