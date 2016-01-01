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
     * Update mail settings
     *
     * @param int    $userId
     * @param array  $settings
     *
     * @return bool
     */
    public function updateSettings($userId, array $settings)
    {
        return !!$this->mailNotify->update(
            $settings, ['user_id' => $userId]
        );
    }
}
