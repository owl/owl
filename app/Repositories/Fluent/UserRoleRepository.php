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
     * Get all user role data.
     *
     * @return stdClass
     */
    public function getAll()
    {
        return \DB::table($this->getTableName())
            ->orderBy('id', 'asc')
            ->get();
    }
}
