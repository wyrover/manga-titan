<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMangaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 30);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('manga', function(Blueprint $table){
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->integer('views')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('category')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });

        Schema::create('manga_page', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_manga')->unsigned();
            $table->integer('page_num')->unsigned();
            $table->string('img_path', 255);
            $table->timestamps();

            $table->foreign('id_manga')->references('id')->on('manga')->onDelete('CASCADE')->onUpdate('CASCADE');
        });

        Schema::create('rating', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_manga')->unsigned();
            $table->integer('id_users')->unsigned();
            $table->tinyInteger('rating')->unsigned();
            $table->timestamps();

            $table->foreign('id_manga')->references('id')->on('manga')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_manga')->unsigned();
            $table->integer('id_users')->unsigned();
            $table->integer('id_comments')->unsinged()->nullable();
            $table->text('comment');
            $table->timestamps();

            $table->foreign('id_manga')->references('id')->on('manga')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
        });

        Schema::create('favorite', function (Blueprint $table) {
            $table->integer('id_manga')->unsigned();
            $table->integer('id_users')->unsigned();
            $table->timestamps();

            $table->foreign('id_manga')->references('id')->on('manga')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('rating');
        Schema::dropIfExists('manga_page');
        Schema::dropIfExists('manga');
        Schema::dropIfExists('category');
    }

}
