<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parcel_id')->index()->unique();
            $table->string('recipient_name');
            $table->text('address');
            $table->string('type')->default('Box');
            $table->integer('weight')->default(9);
            $table->string('delivery_instructions');
            $table->tinyInteger('priority')->default(1);
            $table->string('damage');
            $table->boolean('delivered')->default(false);
            $table->integer('run_id')->index()->unsigned();
            $table->foreign('run_id')->references('id')->on('runs')->onDelete('cascade');
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
        Schema::drop('parcels');
    }
}
