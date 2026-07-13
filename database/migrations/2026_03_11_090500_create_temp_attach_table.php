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
        Schema::create('temp_attach', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_attach')->nullable();
            $table->string('affected_house')->nullable();
            $table->string('builtup_property')->nullable();
            $table->string('entitlement')->nullable();
            $table->string('allot_com')->nullable();
            $table->string('allot_order')->nullable();
            $table->string('chit_mapping')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_attach');
    }
};

