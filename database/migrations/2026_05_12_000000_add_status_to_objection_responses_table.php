<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('objection_responses', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected', 'dismissed'])->default('pending')->after('response_text');
        });
    }

    public function down(): void
    {
        Schema::table('objection_responses', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
