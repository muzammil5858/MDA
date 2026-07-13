<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objections', function (Blueprint $table) {
            $table->id();
            // Link to your main property/request table
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');

            // Who raised it and what was their role at that moment
            $table->foreignId('raised_by_id')->constrained('users');
            $table->string('raised_by_role'); // e.g., 'deo', 'hmd', 'sub-engineer'

            $table->string('objection_type');
            $table->text('remarks');

            // Status to track if the issue is still blocking the process
            $table->enum('status', ['pending', 'resolved'])->default('pending');
            $table->date('objection_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objections');
    }
};
