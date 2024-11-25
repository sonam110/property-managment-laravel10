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
        Schema::create('tenant_property_utilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->date('bill_date')->nullable();
            $table->decimal('energy_charge',10,2)->nullable();
            $table->decimal('fppas',10,2)->nullable();
            $table->decimal('energy_duty',10,2)->nullable();
            $table->decimal('tod_net_sum',10,2)->nullable();
            $table->decimal('energy_charge_as_per_bill',10,2)->nullable();
            $table->decimal('total_units',10,2)->nullable();
            $table->longText('tenants_units')->nullable();
            $table->decimal('tod_rebate_charge',10,2)->nullable();
            $table->decimal('per_unit_charge',10,2);
            $table->decimal('total_tenant_units',10,2)->nullable();
            $table->decimal('unit_lost',10,2)->nullable();
            $table->decimal('energy_losses',10,2)->nullable();
            $table->decimal('energy_losses_per_tenant_unit',10,2)->nullable();
            $table->decimal('energy_unit_per_unit',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenat_property_utilities');
    }
};
