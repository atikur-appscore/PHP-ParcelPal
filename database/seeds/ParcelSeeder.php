<?php

use Illuminate\Database\Seeder;
use App\Parcel;

class ParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Parcel::class, 30)->create();
    }
}
