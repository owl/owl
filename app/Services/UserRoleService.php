<?php namespace Owl\Services;

use Owl\Repositories\UserRoleRepositoryInterface;
use Carbon\Carbon;

class UserRoleService extends Service
{
    const ROLE_ID_MEMBER = 1;
    const ROLE_ID_OWNER = 2;

    protected $userRoleRepo;

    public function __construct(
        UserRoleRepositoryInterface $userRoleRepo
    ) {
        $this->userRoleRepo = $userRoleRepo;
    }

    public function getAll()
    {
        return $this->userRoleRepo->getAll();
    }
}
