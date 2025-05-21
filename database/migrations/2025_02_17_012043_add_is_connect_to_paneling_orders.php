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
        Schema::table('paneling_orders', function (Blueprint $table) {
            $table->boolean('is_connect')->comment('1=>متصل 
            0=>منفصل');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paneling_orders', function (Blueprint $table) {
            //
        });
    }
};
