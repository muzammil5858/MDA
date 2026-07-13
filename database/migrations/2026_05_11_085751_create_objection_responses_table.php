<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objection_responses', function (Blueprint $table) {
            $table->id();
            // Links back to the specific objection thread
            $table->foreignId('objection_id')->constrained('objections')->onDelete('cascade');

            // The person responding (could be the User or another Officer)
            $table->foreignId('user_id')->constrained('users');

            $table->text('response_text');

            // If the user needs to upload a corrected map or document
            $table->string('attachment')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objection_responses');
    }
};
