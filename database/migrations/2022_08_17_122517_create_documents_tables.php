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

        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('original_filename');
            $table->string('filename')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('submitted');
            $table->string('qrcode')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('documents_user_id_foreign');
        });
        Schema::dropIfExists('documents');
    }
};
