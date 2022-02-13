<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tech entities are programming languages and technologies.
        Schema::create('tech_entities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url_name')->unique();
            $table->string('pretty_name')->unique();
            $table->string('cm_mode');
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
        Schema::dropIfExists('tech_entities');
    }
}
