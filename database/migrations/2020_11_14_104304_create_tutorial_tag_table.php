<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorial_tag', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('tutorial_id');
            $table->foreign('tutorial_id')->references('id')->on('tutorials');

            $table->unsignedInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags');
            // Migrations are not used anymore.
            // Tables structures are edited manually though db client.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tutorial_tag', function(Blueprint $table)
        {
            $table->dropForeign(['tag_id']);
        });


        Schema::dropIfExists('tutorial_tag');
    }
}
