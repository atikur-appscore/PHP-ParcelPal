<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = 'System';
        $user->email = 'system@system.com';
        $user->type_id = 2;
        $user->password = bcrypt('system@123+');
        $user->save();

        $user = new User();
        $user->first_name = 'Admin';
        $user->type_id = 2;
        $user->email = 'admin@local.com';
        $user->password = bcrypt('123456');
        $user->save();
    }
}
