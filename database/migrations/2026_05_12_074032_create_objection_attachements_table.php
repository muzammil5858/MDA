<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objection_attachments', function (Blueprint $table) {
            $table->id();

            // Link to the specific response/message
            $table->foreignId('objection_response_id')
                  ->constrained('objection_responses')
                  ->onDelete('cascade');

            // File details
            $table->string('file_path');
            $table->string('file_name'); // Original name for user reference
            $table->string('file_size')->nullable();

            // The "What is this?" column
            $table->string('document_type'); // e.g., 'map', 'id_card', 'tax_receipt'

            // The "Is it correct?" column
            // pending: waiting for review
            // accepted: the authority likes it
            // rejected: user needs to try again
            // superseded: this is an old version replaced by a new upload
            $table->enum('status', ['pending', 'accepted', 'rejected', 'superseded'])
                  ->default('pending');

            // For tracking who rejected/accepted it (optional but helpful)
            $table->foreignId('action_by_id')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objection_attachments');
    }
};
