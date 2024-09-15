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
        Schema::create('product_temperature_change', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('temperature_changement_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('temperature_changement_id')->references('id')->on('temperature_changements');
            $table->dateTime('start_date');
            $table->string('start_temperature');
            $table->boolean('is_finished');
            $table->dateTime('end_date')->nullable();
            $table->string('end_temperature')->nullable();
            $table->string('corrective_action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_temperature_change');
    }
};
