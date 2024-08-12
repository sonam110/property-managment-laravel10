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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('created_by')->nullable();

            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->integer('data_id')->nullable();
            $table->string('type')->nullable()->comment('like: Dpr-Config, DprImport, Project, User, Vendor, WorkPackage');
            $table->string('event')->nullable()->comment('like: Created');
            $table->string('status_code', 50)->default('success')->nullable()->comment('success, failed, warning, primary, secondary, error, alert, info');
            $table->boolean('read_status')->default(0); 
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
