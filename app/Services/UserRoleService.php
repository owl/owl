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
     * 指定されたIDのユーザが退会済みかどうかチェック
     *
     * @param int  $userId
     *
     * @return bool
     */
    public function isRetire($userId)
    {
        $status = $this->userRoleRepo->getByUserId($userId);

        if (is_null($status)) {
            return false;
        }

        return $status->name === '退会済み';
    }
}
