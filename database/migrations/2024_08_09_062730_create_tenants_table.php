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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('unique_id')->unique()->nullable();
            $table->string('tenant_type')->nullable()->comment('Business,Individual');
            $table->string('gender')->nullable();
            $table->string('merital_status')->nullable();
            $table->string('kin_name', 500)->nullable();
            $table->string('kin_mobile')->nullable();
            $table->string('kin_relation')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_mobile')->nullable();
            $table->string('emergency_contact_email')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->text('emergency_postal_address')->nullable();
            $table->text('emergency_residential_address')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('employment_status_mobile')->nullable();
            $table->string('employment_status_email')->nullable();
            $table->text('employment_postal_address')->nullable();
            $table->text('employment_residential_address')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_industry')->nullable();
            $table->string('license_no')->nullable();
            $table->string('tax_id')->nullable();
            $table->text('business_address')->nullable();
            $table->text('business_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
