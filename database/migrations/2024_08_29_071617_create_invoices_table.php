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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('random_no')->nullable();
            $table->string('invoice_no')->unique()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('partner_id');

            $table->unsignedBigInteger('lease_id');
            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');

            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('tenant_id');
            $table->timestamp('invoice_generate_date')->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->string('hsn_sac')->nullable();
            $table->decimal('partner_per',10,2)->nullable();
            $table->integer('partner_type')->nullable();
            $table->integer('is_gst')->nullable();
            $table->decimal('rent_total',10,2)->nullable();
            $table->decimal('rent_cgst_per',10,2)->nullable();
            $table->decimal('rent_cgst_amount',10,2)->nullable();
            $table->decimal('rent_sgst_per',10,2)->nullable();
            $table->decimal('rent_sgst_amount',10,2)->nullable();
            $table->decimal('rent_total_amount',10,2)->nullable();
            $table->decimal('cam_total',10,2)->nullable();
            $table->decimal('cam_cgst_per',10,2)->nullable();
            $table->decimal('cam_cgst_amount',10,2)->nullable();
            $table->decimal('cam_sgst_per',10,2)->nullable();
            $table->decimal('cam_sgst_amount',10,2)->nullable();
            $table->decimal('cam_total_amount',10,2)->nullable();
            $table->decimal('utility_total',10,2)->nullable();
            $table->decimal('grand_total',10,2)->nullable();
            $table->decimal('grand_total',10,2)->nullable();
            $table->string('invoice_type')->nullable()->comment('rent','gst','Cam','Utility');
            $table->string('status')->default('Pending')->nullable()->comment('Pending','Paid','UnPaid','Partial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
