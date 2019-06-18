<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_receivers', function (Blueprint $table) {
            $table->bigIncrements('messagesReceiversId');
            $table->unsignedBigInteger('messageId');
            $table->unsignedBigInteger('receiverId');
            $table->timestamps();

            $table->foreign('messageId')
                    ->references('messageId')->on('messages')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('receiverId')
                    ->references('receiverId')->on('receivers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages_receivers');
    }
}
