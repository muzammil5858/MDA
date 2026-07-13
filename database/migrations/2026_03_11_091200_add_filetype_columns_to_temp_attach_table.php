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
        Schema::table('temp_attach', function (Blueprint $table) {
            $table->string('pdf')->nullable()->after('chit_mapping');
            $table->string('png')->nullable()->after('pdf');
            $table->string('coraldraw')->nullable()->after('png');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_attach', function (Blueprint $table) {
            $table->dropColumn(['pdf', 'png', 'coraldraw']);
        });
    }
};

