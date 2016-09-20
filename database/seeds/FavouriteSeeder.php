<?php

use Illuminate\Database\Seeder;
use App\Favourite;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Favourite::class, 30)->create();
    }
}
