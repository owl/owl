<?php namespace Owl\Repositories\Fluent;

use Owl\Repositories\UserRoleRepositoryInterface;

class UserRoleRepository extends AbstractFluent implements UserRoleRepositoryInterface
{
    protected $table = 'user_roles';

    /**
     * Get a table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * Get reminder token data by user_id.
     * 
     * @param int $userId 
     * @return Object
     */
    public function getByUserId($userId)
    {
        return \DB::table($this->getTableName())
            ->where('user_id', $userId)
            ->first();
    }
}
