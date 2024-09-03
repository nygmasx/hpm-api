<?php

use App\Models\AdvancedTracability;
use App\Models\Product;
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
        Schema::create('product_advanced_tracability', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('advanced_tracability_id');
            $table->foreign('advanced_tracability_id')->references('id')->on('advanced_tracabilities')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->date('expiration_date');
            $table->string('quantity');
            $table->string('label_picture');
            $table->timestamps();

            $table->index(['advanced_tracability_id', 'product_id']);
            $table->primary(['advanced_tracability_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_advanced_tracability');
    }
};
