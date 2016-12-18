<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('keywords');
        Schema::create('keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('auto_reply_id');
            $table->string('keyword');
            $table->integer('counter')->default(0);
            $table->timestamps();

            $table->foreign('auto_reply_id')->references('id')->on('auto_replies')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keywords');
        Schema::create('keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keyword')->unique();
            $table->string('reply', 320);
            $table->integer('counter')->default(0);
            $table->timestamps();
        });
    }
}
