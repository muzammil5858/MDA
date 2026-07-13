<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attchements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->string('order_attach')->nullable();
            $table->string('affected_house')->nullable();
            $table->string('builtup_property')->nullable();
            $table->string('entitlement')->nullable();
            $table->string('allot_com')->nullable();
            $table->string('allot_order')->nullable();
            $table->string('chit_mapping')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attchements');
    }
};
