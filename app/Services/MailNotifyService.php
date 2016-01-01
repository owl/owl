<?php

/**
 * @copyright (c) owl
 */
namespace Owl\Services;

use Owl\Repositories\UserMailNotificationRepositoryInterface as UserMailNotificationRepository;

/**
 * Class MailNotifyService
 * ユーザのメール通知設定のドメインクラス
 *
 * @package Owl\Services
 */
class MailNotifyService
{
    /** @var UserMailNotificationRepository */
    protected $mailNotify;

    /**
     * @param UserMailNotificationRepositry  $userMailNotification
     */
    public function __construct(
        UserMailNotificationRepository $userMailNotification
    ) {
        $this->mailNotify = $userMailNotification;
    }

    /**
     * Get all mail notification settings
     *
     * @param int  $userId
     *
     * @return \stdclass
     */
    public function getSettings($userId)
    {
        return $this->mailNotify->get($userId);
    }

    /**
     * Update mail setting
     *
     * @param int     $userId
     * @param string  $type
     * @param int     $flag
     *
     * @return bool
     */
    public function updateSettings($userId, $type, $flag)
    {
        $columnName = $this->getFlagColomunName($type);

        return !!$this->mailNotify->update(
            [$columnName => $flag],
            ['user_id' => $userId]
        );
    }

    /**
     * Get target column name by specified string
     *
     * @param string $type
     *
     * @return string
     */
    protected function getFlagColomunName($type)
    {
        return $type.'_notification_flag';
    }
}
