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
        if (!Schema::hasTable('qa_properties')) {
            Schema::create('qa_properties', function (Blueprint $table) {
                $table->id();

                $table->foreignId('property_id')
                    ->constrained('properties')
                    ->onDelete('cascade');

                $table->foreignId('user_id')
                    ->constrained('users')
                    ->onDelete('cascade');

                $table->boolean('status')->default(false);
                $table->string('issue')->nullable();
                $table->text('remarks')->nullable();

                $table->timestamps();
            });

            return;
        }

        $columns = Schema::getColumnListing('qa_properties');

        if (!in_array('property_id', $columns, true)) {
            Schema::table('qa_properties', function (Blueprint $table) {
                $table->foreignId('property_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('properties')
                    ->onDelete('cascade');
            });
        }

        if (!in_array('user_id', $columns, true)) {
            Schema::table('qa_properties', function (Blueprint $table) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('property_id')
                    ->constrained('users')
                    ->onDelete('cascade');
            });
        }

        if (!in_array('status', $columns, true)) {
            Schema::table('qa_properties', function (Blueprint $table) {
                $table->boolean('status')->default(false)->after('user_id');
            });
        }

        if (!in_array('issue', $columns, true)) {
            Schema::table('qa_properties', function (Blueprint $table) {
                $table->string('issue')->nullable()->after('status');
            });
        }

        if (!in_array('remarks', $columns, true)) {
            Schema::table('qa_properties', function (Blueprint $table) {
                $table->text('remarks')->nullable()->after('issue');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qa_properties');
    }
};
