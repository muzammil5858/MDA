<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Entry Creation card ke liye log table.
 * Jab bhi user watched fields me se kisi field me nai value add/change kare ga,
 * PropertyController us date ka log yahan save kare ga.
 *
 * Command: php artisan make:migration create_property_field_entries_table --create=property_field_entries
 * (ya is file ko database/migrations/ me paste kar ke neeche wala command chalayen)
 * php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_field_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('entry_date')->index(); // jis din data add kiya gaya
            $table->json('fields_changed')->nullable(); // kaun se fields update huay
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_field_entries');
    }
};
