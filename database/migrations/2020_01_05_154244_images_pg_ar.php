<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImagesPgAr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_pg_ar', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger("id_images")->unsigned()->nullable();
            $table->bigInteger("id_pages")->unsigned()->nullable();
            $table->bigInteger('id_articles')->unsigned()->nullable();
            $table->foreign("id_images")->references('id')->on("images");
            $table->foreign("id_pages")->references('id')->on("web_pages");
            $table->foreign("id_articles")->references('id')->on("articles");
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
        Schema::dropIfExists('images_pg_ar');
    }
}
