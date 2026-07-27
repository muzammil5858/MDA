<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('size')->nullable()->after('sqrft');
            $table->string('form_no')->nullable()->after('size');
            $table->text('remarks')->nullable()->after('form_no');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'size',
                'form_no',
                'remarks',
            ]);
        });
    }
};
