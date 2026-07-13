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
        Schema::create('representatives', function (Blueprint $table) {
            $table->id();
             $table->enum('type', ['attorney', 'representative']); // seller’s attorney OR buyer’s rep
            $table->string('name');
            $table->string('father_name');
            $table->string('cnic')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('attorney_letter')->nullable(); // path to uploaded file
            $table->string('cnic_front')->nullable();
            $table->string('cnic_back')->nullable();
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
        Schema::dropIfExists('representatives');
    }
};
