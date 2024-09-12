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
        Schema::create('property_units', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->string('property_code')->nullable();
            $table->unsignedBigInteger('unit_type')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('unit_name_prefix')->nullable();
            $table->string('unit_floor')->nullable();
            $table->integer('total_shop')->nullable();
            $table->boolean('is_rented')->default(0)->comment('0:No,1:Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_units');
    }
};
