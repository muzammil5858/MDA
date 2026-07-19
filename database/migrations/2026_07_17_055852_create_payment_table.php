<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                  ->constrained('properties')
                  ->cascadeOnDelete();

            // Step 2: Payment Detail
            $table->decimal('total_price', 15, 2)->nullable();
            $table->decimal('amount_deposited', 15, 2)->nullable();
            $table->decimal('remaining_amount', 15, 2)->nullable();
            $table->decimal('down_payment', 15, 2)->nullable();

            $table->string('initial_notice_no')->nullable();
            $table->date('initial_notice_date')->nullable();

            $table->decimal('total_received_amount', 15, 2)->nullable();
            $table->date('received_amount_date')->nullable();

            // Allotment / Possession
            $table->string('allotment_order_no')->nullable();
            $table->date('allotment_order_date')->nullable();
            $table->string('possession_slip_no')->nullable();
            $table->date('possession_slip_date')->nullable();
            $table->string('boundary_wall_approval')->nullable();
            $table->date('map_approval_date')->nullable();
            $table->string('transfer_order_no')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
