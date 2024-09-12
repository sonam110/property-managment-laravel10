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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('random_id')->nullable();
            $table->string('item_desc')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('rate')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('tax_name')->nullable()->comment('CGST,SGST');
            $table->decimal('tax_per',10,2)->nullable();
            $table->decimal('tax_amount',10,2)->nullable();
            $table->decimal('sub_total',10,2)->nullable();
            $table->string('term')->default('Monthy')->nullable()->comment('Monthy,Yearly');
            $table->string('type')->nullable()->comment('rent,cam,utility');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
