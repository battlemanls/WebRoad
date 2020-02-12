<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StanDorig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stan_dorig', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->string('title');
            $table->longText('url')->nullable();
            $table->longText('body')->nullable();
            $table->longText('img_avatar')->nullable();
            $table->date('date_advice')->nullable();
            $table->date('date_advice_end')->nullable();
            $table->boolean('status')->nullable();

            $table->bigInteger("id_user")->unsigned();

            $table->foreign("id_user")->references('id')->on("users");
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
        Schema::dropIfExists('stan_dorig');
    }
}
