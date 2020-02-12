<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Roads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();

            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->bigInteger("id_user")->unsigned();
            $table->bigInteger('id_type')->unsigned();
            $table->bigInteger('id_region')->unsigned();

            $table->foreign("id_user")->references('id')->on("users");
            $table->foreign("id_type")->references('id')->on("type_roads");
            $table->foreign("id_region")->references('id')->on("regions");
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
        Schema::dropIfExists('roads');
    }
}
