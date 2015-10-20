<?php namespace Owl\Repositories;

interface ReminderTokenRepositoryInterface
{
    /**
     * Get a table name.
     *
     * @return string
     */
    public function getTableName();

    /**
     * Get reminder token data by user_id.
     * 
     * @param int $userId 
     * @return Object
     */
    public function getByUserId($userId);
}
