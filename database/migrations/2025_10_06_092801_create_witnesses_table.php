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
         Schema::create('witnesses', function (Blueprint $table) {
              $table->id();
    $table->unsignedBigInteger('request_id'); // Foreign key to requests table
    $table->unsignedBigInteger('property_id'); // Foreign key to requests table
    $table->string('name');
    $table->string('father_name');
    $table->string('cnic');
    $table->string('address');
    $table->string('picture');
    $table->string('biometric_id');
    $table->string('cnic_front');
    $table->string('cnic_back');
    $table->timestamps();

    // Foreign key constraint
    $table->foreign('request_id')
        ->references('id')
        ->on('requests')
        ->onDelete('cascade'); // Delete receivers if request is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('witnesses');
    }
};
