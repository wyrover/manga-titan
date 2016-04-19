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
        Schema::create('config_apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 20);
            $table->string('name', 200);
            $table->string('content', 255);
        });

        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 40)->unique();
            $table->text('description')->nullable();
            $table->string('thumb_path',255)->nullable();
            $table->timestamps();
        });

        Schema::create('manga', function(Blueprint $table){
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->integer('id_uploader')->unsigned()->nullable();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('thumb_path',255);
            $table->integer('views')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('category')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('id_uploader')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
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

        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_users')->unsigned();

            $table->text('comment');
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
        });

        Schema::create('commentable', function (Blueprint $table) {
            $table->integer('comment_id');
            $table->integer('commentable_id')->unsigned();
            $table->string('commentable_type');
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
        Schema::dropIfExists('commentable');
        Schema::dropIfExists('comment');
        Schema::dropIfExists('rating');
        Schema::dropIfExists('manga_page');
        Schema::dropIfExists('manga');
        Schema::dropIfExists('category');
        Schema::dropIfExists('config_apps');
    }

}
