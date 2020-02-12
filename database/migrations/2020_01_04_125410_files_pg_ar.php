<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FilesPgAr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_pg_ar', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger("id_files")->unsigned()->nullable();
            $table->bigInteger("id_pages")->unsigned()->nullable();
            $table->bigInteger('id_articles')->unsigned()->nullable();
            $table->foreign("id_files")->references('id')->on("files");
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
        Schema::dropIfExists('files_pg_ar');
    }
}
