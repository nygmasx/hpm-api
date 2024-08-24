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
        Schema::create('equipment_temperature', function (Blueprint $table) {
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('temperature_id');
            $table->timestamps();

            $table->primary(['equipment_id', 'temperature_id']);
            $table->foreign('equipment_id')->references('id')->on('equipment');
            $table->foreign('temperature_id')->references('id')->on('temperature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_temperature');
    }
};
