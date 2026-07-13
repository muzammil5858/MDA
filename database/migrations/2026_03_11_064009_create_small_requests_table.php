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
        Schema::create('small_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('request_id');
            $table->boolean('all_documents_verified')->default(0);
            $table->string('architect_name')->nullable();
            $table->string('architect_address')->nullable();
            $table->string('architect_stamp_signature')->nullable();
            $table->string('engineer_name')->nullable();
            $table->string('engineer_address')->nullable();
            $table->string('engineer_stamp_signature')->nullable();
            $table->string('approved_map')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('small_requests');
    }
};
