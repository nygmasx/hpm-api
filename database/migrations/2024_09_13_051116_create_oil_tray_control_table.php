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
        Schema::create('oil_tray_control', function (Blueprint $table) {
            $table->unsignedBigInteger('oil_control_id');
            $table->unsignedBigInteger('oil_tray_id');
            $table->foreign('oil_control_id')->references('id')->on('oil_controls');
            $table->foreign('oil_tray_id')->references('id')->on('oil_trays');
            $table->string('control_type');
            $table->string('temperature');
            $table->string('polarity');
            $table->string('corrective_action')->nullable();
            $table->string('image_url')->nullable();
            $table->text('comment')->nullable();
            $table->primary(['oil_control_id', 'oil_tray_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_tray_control');
    }
};
