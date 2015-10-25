<?php namespace Owl\Repositories\Eloquent;

use Owl\Repositories\UserRoleRepositoryInterface;
use Owl\Repositories\Eloquent\Models\UserRole;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    protected $userRole;

    public function __construct(UserRole $userRole)
    {
        $this->userRole = $userRole;
    }
}
