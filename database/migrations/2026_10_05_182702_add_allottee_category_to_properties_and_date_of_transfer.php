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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('allottee_category')->nullable();
        });

        Schema::table('current_owners', function (Blueprint $table) {
            $table->date('date_of_transfer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('allottee_category');
        });

        Schema::table('current_owners', function (Blueprint $table) {
            $table->dropColumn('date_of_transfer');
        });
    }
};
