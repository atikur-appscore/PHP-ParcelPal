<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatitudeLongitudeToFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favourites', function($table) {
            $table->float('latitude', 10, 7)->after('state');
            $table->float('longitude', 10, 7)->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favourites', function($table) {
            $table->dropColumn(array('latitude', 'longitude'));
        });
    }
}
