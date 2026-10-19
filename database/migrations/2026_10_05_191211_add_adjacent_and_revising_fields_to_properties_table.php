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
            $table->string('adjacent_area')->nullable();
            $table->decimal('adjacent_price', 15, 2)->nullable();
            $table->string('adjacent_allotment_no')->nullable();
            $table->date('adjacent_allotment_date')->nullable();
            
            $table->string('revising_notice_no')->nullable();
            $table->date('revising_notice_date')->nullable();
            $table->string('revising_notice_status')->nullable();
            $table->decimal('revising_penalty_amount', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'adjacent_area',
                'adjacent_price',
                'adjacent_allotment_no',
                'adjacent_allotment_date',
                'revising_notice_no',
                'revising_notice_date',
                'revising_notice_status',
                'revising_penalty_amount'
            ]);
        });
    }
};
