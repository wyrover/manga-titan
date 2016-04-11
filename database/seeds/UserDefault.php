<?php

use Illuminate\Database\Seeder;

class UserDefault.php extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sentinel::registerAndActivate([
        	'email' => 'admin@admin.com',
        	'password' => 'administrator',
            'permissions' => [
                'admin' => true
            ],
            'first_name' => 'admin',
        	]);
    }
}
