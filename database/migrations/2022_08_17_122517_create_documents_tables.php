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
            $table->string('filename');
            $table->string('state');
            $table->string('qrcode')->nullable();
            $table->integer('userid')->unsigned();
            $table->timestamps();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('userid')->references('id')->on('users');
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
            $table->dropForeign('documents_userid_foreign');
        });
        Schema::dropIfExists('documents');


    }
};
