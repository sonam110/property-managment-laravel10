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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 500);
            $table->string('middle_name', 500)->nullable();
            $table->string('last_name', 500)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->string('mobile')->nullable();
            $table->text('postal_address')->nullable();
            $table->text('residential_address')->nullable();
            $table->integer('country')->nullable();
            $table->integer('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('national_id_no')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('locktimeout')->default('10')->comment('System auto logout if no activity found.');
            $table->boolean('status')->default('1')->comment('1:Active, 0:Inactive');
            $table->timestamp('last_login_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
