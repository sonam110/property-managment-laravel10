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
            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->unsignedBigInteger('tenant_id');
            $table->longText('unit_ids');
            $table->unsignedBigInteger('lease_type')->nullable();
            $table->decimal('rent_amount',10,2)->default(0);
            $table->timestamp('start_date');
            $table->integer('due_on')->default(1);
            $table->decimal('rent_deposite_amount',10,2)->default(0);
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
