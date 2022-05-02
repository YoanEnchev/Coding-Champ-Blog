<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('tutorial_id');
            $table->foreign('tutorial_id')->references('id')->on('tutorials');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('comments')
                ->onDelete('set null');

            $table->string('text', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function(Blueprint $table)
        {
            $table->dropForeign(['tutorial_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parent_id']);
        });


        Schema::dropIfExists('comments');
    }
}
