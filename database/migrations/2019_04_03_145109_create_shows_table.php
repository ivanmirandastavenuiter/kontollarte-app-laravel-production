<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->string('showId')->primary();
            $table->date('showStartingDate')->nullable();
            $table->date('showEndingDate')->nullable();
            $table->string('showName');
            $table->text('showDescription');
            $table->tinyInteger('showOrder');
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
        Schema::dropIfExists('shows');
    }
}
