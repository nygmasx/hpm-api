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
        Schema::create('temperature_changements', function (Blueprint $table) {
            $table->id();
            $table->string('operation_type');
            $table->text('additional_informations')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('start_date');
            $table->string('start_temperature');
            $table->boolean('is_finished')->nullable();
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
        Schema::dropIfExists('temperature_changements');
    }
};
