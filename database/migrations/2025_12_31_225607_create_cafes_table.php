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
        Schema::create('cafes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('google_maps_url')->nullable();
            $table->enum('status', ['pending', 'active', 'deleted'])->default('pending');
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index(['latitude', 'longitude']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafes');
    }
};
