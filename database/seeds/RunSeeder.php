<?php

use Illuminate\Database\Seeder;
use App\Run;

class RunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Run::class, 30)->create();
    }
}
