<?php namespace Owl\Repositories\Fluent;

/**
 * @copyright (c) owl
 */

use Owl\Repositories\UserMailNotificationRepositoryInterface;
use Owl\Repositories\Fluent\AbstractFluent;

/**
 * Class UserMailNotificationRepository
 *
 * @package Owl\Repositories\Fluent
 */
class UserMailNotificationRepository extends AbstractFluent implements UserMailNotificationRepositoryInterface
{
    /** @var string  Table name */
    protected $table = 'user_mail_notifications';

    /** @var string  Primary key for table */
    protected $primary = 'user_id';

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * Get data by user ID
     *
     * @param int  $userId
     *
     * @return null | \stdclass
     */
    public function get($userId)
    {
        return $this->builder()
            ->where($this->primary, $userId)
            ->first();
    }
}
