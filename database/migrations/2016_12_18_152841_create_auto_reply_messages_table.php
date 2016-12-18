<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
