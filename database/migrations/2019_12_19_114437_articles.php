<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->string('title');
            $table->longText('excerpt')->nullable();
            $table->longText('body');
            $table->longText('youtube')->nullable();
            $table->longText('img_avatar')->nullable();
            $table->date('date_advice')->nullable();
            $table->date('date_advice_end')->nullable();
            $table->boolean('status')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->bigInteger("id_user")->unsigned();
            $table->bigInteger('id_type')->unsigned();

            $table->foreign("id_user")->references('id')->on("users");
            $table->foreign("id_type")->references('id')->on("type_articles");
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
        Schema::dropIfExists('articles');
    }
}
