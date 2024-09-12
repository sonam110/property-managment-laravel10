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
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique()->nullable();
            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->unsignedBigInteger('tenant_id');
            $table->longText('unit_ids');
            $table->timestamp('start_date');
            $table->integer('due_on')->default(1);
            $table->decimal('total_square',10,2)->default(0);
            $table->decimal('price',10,2)->default(0)->nullable();
            $table->decimal('fixed_price',10,2)->default(0)->nullable();
            $table->decimal('square_foot',10,2)->default(0)->nullable();
            $table->decimal('cam_square_foot',10,2)->default(0)->nullable();
            $table->decimal('camp_price',10,2)->default(0)->nullable();
            $table->decimal('camp_fixed_price',10,2)->default(0)->nullable();
            $table->integer('end_month')->default(11)->nullable();
            $table->integer('month')->nullable();
            $table->decimal('inc_percenatge',10,2)->nullable();
            $table->integer('cam_month')->nullable();
            $table->decimal('cam_inc_percenatge',10,2)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->integer('generate_invoice_day')->nullable();
            $table->text('invoice_conditions')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
