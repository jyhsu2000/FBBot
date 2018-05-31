<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoReplyMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_reply_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('auto_reply_id');
            $table->string('content', 320);
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
        Schema::dropIfExists('auto_reply_messages');
    }
}
