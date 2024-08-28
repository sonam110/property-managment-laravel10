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
        Schema::create('property_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->decimal('commission_value',10,2)->default(0)->nullable();
            $table->integer('commission_type')->nullable()->comment('1:Fixed,2:% of Total Rent,3: % of Total collected Rent');
            $table->longText('payment_methods')->nullable();
            $table->boolean('is_gst')->default(0)->nullable()->comment('0:No,1:Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_payment_settings');
    }
};
