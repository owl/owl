<?php namespace Owl\Repositories;

/**
 * @copyright (c) owl
 */

/**
 * Interface UserMailNotificationRepositoryInterface
 */
interface UserMailNotificationRepositoryInterface
{
    /**
     * Get data by user ID
     *
     * @param int  $userId
     *
     * @return null | \stdclass
     */
    public function get($userId);
}
