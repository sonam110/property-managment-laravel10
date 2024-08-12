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
            $table->unsignedBigInteger('lease_id');
            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->timestamp('period')->nullable();
            $table->decimal('amount',10,2)->default(0);
            $table->decimal('paid_amount',10,2)->default(0);
            $table->decimal('balance',10,2)->default(0);
            $table->date('due_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
