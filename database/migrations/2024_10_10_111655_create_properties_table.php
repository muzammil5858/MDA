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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

    $table->integer('district');
    $table->integer('center');
    $table->integer('locality');
    $table->string('code');
    $table->string('d_category');
    $table->integer('dm_acre');
    $table->integer('dm_kanal');
    $table->integer('dm_marla');
    $table->integer('dm_sqrft');
    $table->string('category');
    $table->integer('acre');
    $table->integer('kanal');
    $table->integer('marla');
    $table->integer('sqrft');
    $table->string('alotment_order');
    $table->string('alotment_date'); // Changed to date type
    $table->string('plot_no')->nullable(); // Nullable string field
    $table->string('evacue_owner')->nullable();
    $table->string('com_date'); // Changed to date type
    $table->string('allotee_name');
    $table->string('relation')->nullable();
    $table->string('cnic', 15); // CNIC length fixed
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
        Schema::dropIfExists('properties');
    }
};
