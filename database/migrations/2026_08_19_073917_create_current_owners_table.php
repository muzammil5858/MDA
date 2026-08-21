<?php
// database/migrations/xxxx_xx_xx_create_current_owners_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('current_owners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('applicant_name')->nullable();
            $table->string('father_husband_name')->nullable();
            $table->string('old_nic')->nullable();
            $table->string('cnic')->nullable();
            $table->text('address_temporary')->nullable();
            $table->text('address_permanent')->nullable();
            $table->timestamps();

            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
                   // Index for faster queries
            $table->index('property_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('current_owners');
    }
};
