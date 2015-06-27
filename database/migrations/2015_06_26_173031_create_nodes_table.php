<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hub_id')->nullable();
            $table->string('uuid');
            $table->tinyInteger('generation');
            $table->enum('type', ['DEPTH']);
            $table->integer('capacity');
            $table->timestamps();
            $table->timestamp('connected_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nodes');
    }
}
