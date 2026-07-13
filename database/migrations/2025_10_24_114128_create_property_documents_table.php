<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('property_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('request_id')->nullable();
            $table->string('document_type'); // e.g. transfer_order, char_deewari, access_letter
            $table->string('file_path'); // stored file path
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Foreign keys (optional)
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_documents');
    }
};
