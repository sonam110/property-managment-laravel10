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
        Schema::create('lease_extra_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id');
            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->unsignedBigInteger('extra_charge_id');
            $table->decimal('extra_charge_value',10,2)->default(0);
            $table->integer('extra_charge_type')->nullable()->comment('1:Fixed,2:% of Total Rent,3: % of Total Amount Over Due');
            $table->integer('frequency')->nullable()->comment('1:Onetime,2:Period to Period,3:Daily,4:Weekly,5:Monthly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_extra_charges');
    }
};
