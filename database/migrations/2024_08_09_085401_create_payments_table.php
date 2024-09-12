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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('lease_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();

            $table->decimal('grand_total',10,2)->default(0)->nullable();
            $table->decimal('total_amount',10,2)->default(0)->nullable();
            $table->decimal('amount',10,2)->default(0)->nullable();
            $table->decimal('remaining_amount',10,2)->default(0)->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('paid_by')->nullable();
            $table->string('reference_no')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('Pending')->nullable()->comment('Full','Partial','Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
