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
        Schema::create('cleaning_plan_operation', function (Blueprint $table) {
            $table->unsignedBigInteger('cleaning_plan_id');
            $table->unsignedBigInteger('cleaning_zone_id');
            $table->unsignedBigInteger('cleaning_station_id');
            $table->foreign('cleaning_plan_id')->references('id')->on('cleaning_plans');
            $table->foreign('cleaning_zone_id')->references('id')->on('cleaning_zones');
            $table->foreign('cleaning_station_id')->references('id')->on('cleaning_stations');
            $table->text('comment')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->index(['cleaning_plan_id', 'cleaning_zone_id', 'cleaning_station_id'], 'cleaning_plan_zone_station_idx');
            $table->primary(['cleaning_plan_id', 'cleaning_zone_id', 'cleaning_station_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaning_plan_operation');
    }
};
