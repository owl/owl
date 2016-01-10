<?php namespace Owl\Repositories;

/**
 * @copyright (c) owl
 */

/**
 * Interface UserRoleRepositoryInterface
 */
interface UserRoleRepositoryInterface
{
    /**
     * @return array
     */
    public function getAll();

    /**
     * @param int  $userId
     *
     * @return \stdClass | null
     */
    public function getByUserId($userId);
}
