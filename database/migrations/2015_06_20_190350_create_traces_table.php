<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hub_id');
            $table->integer('node_id');
            $table->string('node_generation');
            $table->enum('type', ['DEPTH']);
            $table->integer('value');
            $table->timestamp('created_at_node');
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
        Schema::drop('traces');
    }
}
