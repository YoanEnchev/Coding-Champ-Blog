<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('tech_entity_id');
            $table->foreign('tech_entity_id')->references('id')->on('tech_entities');
            
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->string('pretty_name');
            $table->string('url_name');

            $table->string('keywords');
            $table->text('description');

            $table->unsignedInteger('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tutorials', function(Blueprint $table)
        {
            $table->dropForeign(['tech_entity_id', 'category_id']);
        });

        Schema::dropIfExists('tutorials');
    }
}
