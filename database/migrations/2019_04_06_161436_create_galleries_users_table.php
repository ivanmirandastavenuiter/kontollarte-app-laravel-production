<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries_users', function (Blueprint $table) {
            $table->increments('galleriesUsersId');
            $table->unsignedBigInteger('userId');
            $table->string('galleryId');
            $table->date('gallerySignup');
            $table->timestamps();

            $table->foreign('userId')
                    ->references('userId')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('galleryId')
                    ->references('galleryId')->on('galleries')
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
        Schema::dropIfExists('galleries_users');
    }
}
