<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plot_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                  ->constrained('properties')
                  ->cascadeOnDelete();

            // Step 3: Transferee row (one property can have many transferees)
            $table->string('name')->nullable();
            $table->string('id_card')->nullable();
            $table->string('challan_no')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plot_histories');
    }
};
