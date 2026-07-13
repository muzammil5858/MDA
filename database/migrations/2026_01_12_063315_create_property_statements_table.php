<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_statements', function (Blueprint $blueprint) {
            $blueprint->id();
            
            // Foreign Keys
            $blueprint->foreignId('request_id')->constrained('requests')->onDelete('cascade');
            $blueprint->foreignId('property_id')->constrained('properties')->onDelete('cascade');

            // Statement Columns (LongText for HTML data)
            $blueprint->longText('requester_statement')->nullable();
            $blueprint->longText('receiver_statement')->nullable();
            $blueprint->longText('transfer_order')->nullable();
            $blueprint->longText('nakle_bala')->nullable();

            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_statements');
    }
};
