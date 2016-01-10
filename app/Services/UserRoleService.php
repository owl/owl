<?php namespace Owl\Services;

/**
 * @copyright (c) owl
 */

use Owl\Repositories\UserRoleRepositoryInterface;
use Carbon\Carbon;

/**
 * Class UserRoleService
 *
 * @package Owl\Services
 */
class UserRoleService extends Service
{
    const ROLE_ID_MEMBER = 1;
    const ROLE_ID_OWNER = 2;

    /** @var UserRoleRepositoryInterface */
    protected $userRoleRepo;

    /**
     * @param UserRoleRepositoryInterface  $userRoleRepo
     */
    public function __construct(
        UserRoleRepositoryInterface $userRoleRepo
    ) {
        $this->userRoleRepo = $userRoleRepo;
    }

    /**
     * Get all data.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->userRoleRepo->getAll();
    }

    /**
     * Get data by specified user ID
     *
     * @param int  $userId
     *
     * @return \stdClass | null
     */
    public function getByUserId($userId)
    {
        return $this->userRoleRepo->getByUserId($userId);
    }
}
