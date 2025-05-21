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
        Schema::create('paneling_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paneling_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('color_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('embroider_color_id')->constrained('colors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paneling_colors');
    }
};
