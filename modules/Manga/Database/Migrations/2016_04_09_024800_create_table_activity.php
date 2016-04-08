<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActivity extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('activity', function(Blueprint $table)
        // {
        //     $table->increments('id');
        //     $table->integer('id_manga')->unsigned();
        //     $table->integer('id_users')->unsigned();
        //     $table->timestamps();

        //     $table->foreign('id_manga')->references('id')->on('manga')->onDelete('cascade')->onUpdate('cascade');
        //     $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('');
    }

}
