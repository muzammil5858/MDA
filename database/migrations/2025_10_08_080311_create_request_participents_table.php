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
        Schema::create('request_participents', function (Blueprint $table) {
            $table->id();
             
            $table->foreignId('transfer_file_id')->constrained('transfer_files')->onDelete('cascade');
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('inheritance')->onDelete('cascade');
            $table->enum('mode', ['self', 'attorney', 'shared_attorney'])->default('self');
            $table->foreignId('representative_id')
                ->nullable()
                ->constrained('representatives')
                ->nullOnDelete();
            
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
        Schema::dropIfExists('request_participents');
    }
};
