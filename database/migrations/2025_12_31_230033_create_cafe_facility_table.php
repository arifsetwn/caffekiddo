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
        Schema::create('cafe_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cafe_id')->constrained()->onDelete('cascade');
            $table->foreignId('facility_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique cafe-facility combinations
            $table->unique(['cafe_id', 'facility_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafe_facility');
    }
};
