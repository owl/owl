<?php

use Illuminate\Database\Seeder;
use Owl\Repositories\Fluent\UserRoleRepository;

class UserRoleTableSeeder extends Seeder
{
    public function run()
    {
        $userRoleRepo = new UserRoleRepository();

        // check data
        $ret = $userRoleRepo->getAll();

        if (! empty($ret)) {
            echo "dont need UserRoleTableSeeder\n";
            return;
        }

        // member
        $params = ['name' => 'メンバー'];
        $userRoleRepo->insert($params);

        // owner
        $params = ['name' => 'オーナー'];
        $userRoleRepo->insert($params);

        // removed
        $params = ['name' => '退会済み'];
        $userRoleRepo->insert($params);
    }
}
