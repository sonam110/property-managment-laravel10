<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('description')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->text('address')->nullable();
            $table->string('Zipcode')->nullable();
            $table->string('website_url')->nullable();
            $table->string('lease_prefix')->nullable();
            $table->string('tenant_prefix')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->string('invoice_disclaimer')->nullable();
            $table->string('invoice_terms')->nullable();
            $table->text('recipt_note')->nullable();
            $table->string('date_format')->nullable();
            $table->integer('generate_invoice_day')->nullable();
            $table->text('invoice_conditions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
};
