<?php

use Illuminate\Database\Seeder;
use Owl\Repositories\Fluent\UserRepository;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $userRepo = new UserRepository();

        // check data
        $ret = $userRepo->getOwners();

        if (! empty($ret)) {
            echo "dont need UserTableSeeder\n";
            return;
        }

        // member
        $params = [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 2 //owner
        ];
        $userRepo->insert($params);
    }
}

