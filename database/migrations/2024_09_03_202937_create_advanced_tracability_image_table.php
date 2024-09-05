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
        Schema::create('advanced_tracability_image', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('advanced_tracability_id');
            $table->foreign('advanced_tracability_id')->references('id')->on('advanced_tracabilities')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->timestamps();

            $table->index(['advanced_tracability_id', 'image_id'], 'adv_trac_img_idx');
            $table->primary(['advanced_tracability_id', 'image_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advanced_tracability_image');
    }
};
