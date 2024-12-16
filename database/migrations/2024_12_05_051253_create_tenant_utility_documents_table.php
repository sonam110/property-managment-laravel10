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
        Schema::create('tenant_utility_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_property_utility_id');
            $table->foreign('tenant_property_utility_id')->references('id')->on('tenant_property_utilities')->onDelete('cascade');

            $table->unsignedBigInteger('tenant_id'))->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_utility_documents');
    }
};
