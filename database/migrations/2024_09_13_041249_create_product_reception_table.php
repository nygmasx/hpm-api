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
        Schema::create('product_reception', function (Blueprint $table) {
            $table->unSignedBigInteger('product_id');
            $table->unSignedBigInteger('reception_id');
            $table->primary(['product_id', 'reception_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('reception_id')->references('id')->on('receptions')->onDelete('cascade');
            $table->index(['product_id', 'reception_id'], 'product_reception_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reception');
    }
};
