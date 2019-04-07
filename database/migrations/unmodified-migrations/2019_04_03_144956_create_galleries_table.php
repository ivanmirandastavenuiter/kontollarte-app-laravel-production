<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Don't know if changin the primary key default name, you also change default autoincrement. If fails, add it.
        // Think so cause that it is when you call it 'id', then if you change the name, you change this default behavior.
        Schema::create('galleries', function (Blueprint $table) {
            $table->string('galleryId')->primary();
            $table->string('galleryName');
            $table->string('galleryAddress');
            $table->string('galleryEmail')->unique();
            $table->string('galleryWeb');
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
        Schema::dropIfExists('galleries');
    }
}
