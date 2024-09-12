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
        Schema::create('rent_cals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lease_id');
            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');
            $table->integer('from_month')->nullable();
            $table->integer('to_month')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->boolean('type')->default(1)->comment('1:Rent,2:Cam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_cals');
    }
};
