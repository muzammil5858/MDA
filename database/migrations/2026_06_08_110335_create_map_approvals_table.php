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
        Schema::create('map_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('request_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();

            // Row 2 fields
            $table->string('drawing_no')->nullable();
            $table->date('drawing_date')->nullable();
            $table->string('drawing_location')->nullable();

            // Row 3-11 toggle fields
            $table->text('allocated_area')->nullable();
            $table->text('road_location')->nullable();
            $table->text('construction_status')->nullable();
            $table->text('plot_size_status')->nullable();
            $table->string('added_area_sq_yards')->nullable();
            $table->string('additional_remarks')->nullable();
            $table->text('impact_on_public')->nullable();
            $table->text('graveyard_status')->nullable();
            $table->text('separate_plot')->nullable();
            $table->text('tor_compliance')->nullable();

            // Row 12 field
            $table->text('existing_condition')->nullable();

            // Status and tracking
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_approvals');
    }
};
