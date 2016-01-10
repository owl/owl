<?php namespace Owl\Services;

/**
 * @copyright (c) owl
 */

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
        $flags = $this->mailNotify->getByUserId($userId);

        // HACK: レコード未登録ユーザはレコード挿入する
        // @link https://github.com/owl/owl/pull/75
        if (is_null($flags)) {
            $this->mailNotify->insert($this->getDefaultColomuns($userId));
            return $this->mailNotify->getByUserId($userId);
        }

        return $flags;
    }

    /**
     * Update mail setting
     *
     * @param int     $userId
     * @param string  $type
     * @param string  $flag
     *
     * @return bool
     */
    public function updateSetting($userId, $type, $flag)
    {
        $columnName = $this->getFlagColomunName($type);

        return !!$this->mailNotify->update(
            [$columnName => $flag === 'true' ? 1 : 0],
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

    /**
     * Get default setting of user's mail notification
     *
     * @param int  $userId
     *
     * @return array
     */
    protected function getDefaultColomuns($userId)
    {
        return [
            'user_id'                    => $userId,
            'comment_notification_flag'  => 0,
            'favorite_notification_flag' => 0,
            'like_notification_flag'     => 0,
            'edit_notification_flag'     => 0,
        ];
    }
}
