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
            $table->string('unique_id')->unique()->nullable();
            $table->string('tenant_type')->default('Business')->comment('Business,Individual');
            $table->text('full_name');
            $table->string('firm_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('country')->default('101')->nullable();
            $table->integer('state')->nullable();
            $table->string('city')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_mobile')->nullable();
            $table->string('emergency_contact_email')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->text('emergency_postal_address')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_industry')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('gst_no')->nullable();
            $table->text('business_address')->nullable();
            $table->text('company_address')->nullable();
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
