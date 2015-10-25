<?php

use Illuminate\Database\Seeder;
use Owl\Repositories\Eloquent\Models\UserRole;

class UserRoleTableSeeder extends Seeder
{
    public function run()
    {
        // member
        $user = new UserRole;
        $user->fill(array(
            'name' => 'メンバー',
        ));
        $user->save();

        // owner
        $user = new UserRole;
        $user->fill(array(
            'name' => 'オーナー',
        ));
        $user->save();

        // removed
        $user = new UserRole;
        $user->fill(array(
            'name' => '退会済み',
        ));
        $user->save();
    }
}

