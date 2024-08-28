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
        Schema::create('lease_utilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id');
            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->unsignedBigInteger('utility_id')->nullable();  
            $table->decimal('variable_cost',10,2)->default(0)->nullable();
            $table->decimal('fixed_cost',10,2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_utilities');
    }
};
