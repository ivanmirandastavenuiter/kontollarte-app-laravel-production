<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paints', function (Blueprint $table) {
            $table->bigIncrements('paintId');
            $table->string('paintName');
            $table->date('paintDate')->nullable();
            $table->text('paintDescription')->nullable();
            $table->string('paintImage');
            $table->boolean('sold')->default(false);
            $table->unsignedBigInteger('userId');
            $table->timestamps();
            $table->foreign('userId')
                    ->references('userId')->on('users')
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
        Schema::dropIfExists('paints');
    }
}
