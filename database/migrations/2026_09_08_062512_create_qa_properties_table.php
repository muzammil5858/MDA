<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qa_properties', function (Blueprint $table) {
            $table->id();

            // Current property
            $table->foreignId('property_id')
                ->constrained('properties')
                ->onDelete('cascade');

            // QA user
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // QA Done = true, Having Issue = false
            $table->boolean('status')
                ->default(false);

            // Issue selected from dropdown
            $table->string('issue')->nullable();

            // Description / remarks
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qa_properties');
    }
};
