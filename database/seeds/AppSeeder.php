<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $token = env('API_TOKEN');
        if (!$token) {
            echo "Default API_TOKEN not found in the environment";
        }
        \DB::table('apps')->insert([
            'name' => 'API Parcel',
            'api_token' => $token,
        ]);
    }
}
