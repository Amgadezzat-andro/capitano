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
        Schema::create('paneling_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('paneling_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('car_chairs',['2','3','5']);
            $table->double('price');
            $table->boolean('is_connect');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paneling_specifications');
    }
};
