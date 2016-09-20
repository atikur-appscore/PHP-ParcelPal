<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamp('date_at');
            $table->time('start_time')->default(null);
            $table->time('end_time')->default(null);
            $table->text('start_location');
            $table->text('end_location');
            $table->integer('distance');
            $table->boolean('calculated')->default(false);
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('runs');
    }
}
