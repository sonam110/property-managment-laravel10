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
            $table->unsignedBigInteger('user_id');
            
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->integer('unit')->nullable()->comment('1:Residentail.2:Commercial');
            $table->string('unit_name');
            $table->string('unit_floor');
            $table->integer('rent_type')->nullable()->comment('1:Square Fit.2:Fixed');
            $table->decimal('rent_amount',10,2)->default(0);
            $table->unsignedBigInteger('unit_type')->nullable();
            $table->integer('bed_rooms')->nullable();
            $table->integer('bath_rooms')->nullable();
            $table->integer('total_rooms')->nullable();
            $table->decimal('square_foot',10,2)->nullable();
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
