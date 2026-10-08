
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
        Schema::create('authorized_login_requests', function (Blueprint $table) {

            $table->id();

            $table->string('cnic', 20);

            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();

            $table->string('device_name')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_brand')->nullable();

            $table->string('os')->nullable();
            $table->string('os_version')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->string('app_version')->nullable();

            $table->dateTime('request_datetime');

            $table->enum('confirmation_status', [
                'Pending',
                'Approved',
                'Rejected'
            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->string('profile_pic')->nullable();

            $table->integer('forced_password')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorized_login_requests');
    }
};
