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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('property_name');
            $table->string('property_code');
            $table->unsignedBigInteger('property_type')->default('1')->nullable();
            $table->string('property_location')->nullable();
            $table->text('property_address')->nullable();
            $table->string('property_lat')->nullable();
            $table->string('property_long')->nullable();
            $table->text('property_description')->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->boolean('status')->default('1')->comment('1:Active, 0:Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
