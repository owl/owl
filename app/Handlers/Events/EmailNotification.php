<?php

/**
 * @copyright (c) owl
 */
namespace Owl\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Contracts\Mail\Mailer;
use Owl\Events\Item\CommentEvent;
use Owl\Events\Item\GoodEvent;
use Owl\Events\Item\FavoriteEvent;
use Owl\Events\Item\EditEvent;
use Owl\Repositories\ItemRepositoryInterface as ItemRepository;
use Owl\Repositories\UserRepositoryInterface as UserRepository;
use Owl\Repositories\UserMailNotificationRepositoryInterface as UserMailNotificationRepository;

/**
 * Class EmailNotification
 * メール送信関連のイベントハンドラークラス
 *
 * @package Owl\Handlers\Events
 */
class EmailNotification {

    /** @var Mailer */
    protected $mail;

    /** @var ItemRepository */
    protected $item;

    /** @var UserRepository */
    protected $user;

    /** @var UserMailNotificationRepository */
    protected $mailNotification;

    /**
     * @param Mailer                          $mailer
     * @param ItemRepository                  $itemRepository
     * @param UserRepository                  $userRepository
     * @param UserMailNotificationRepository  $userMailNotificationRepository
     */
    public function __construct(
        Mailer                         $mailer,
        ItemRepository                 $itemRepository,
        UserRepository                 $userRepository,
        UserMailNotificationRepository $userMailNotificationRepository
    ) {
        $this->mail             = $mailer;
        $this->item             = $itemRepository;
        $this->user             = $userRepository;
        $this->mailNotification = $userMailNotificationRepository;
    }

    /**
     * 記事にコメントがついた時のメール通知
     *
     * @param CommentEvent  $event
     */
    public function onGetComment(CommentEvent $event)
    {
        $item      = $this->item->getByOpenItemId($event->getId());
        $recipient = $this->user->getById($item->user_id);
        $sender    = $this->user->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif ($this->notificationIsEnabled('comment', $recipient->id)) {
            return false;
        }

        $data            = $this->getDataForMail($item, $recipient, $sender);
        $data['comment'] = $event->getComment();

        $this->mail->send(
            'emails.action.comment', $data,
            function ($m) use ($recipient, $sender) {
                $m->to($recipient->email)
                    ->subject($sender->username.'さんからコメントがつきました - Owl');
            }
        );
    }

    /**
     * 記事にいいね！がついた時
     *
     * @param GoodEvent  $event
     */
    public function onGetGood(GoodEvent $event)
    {
        $item      = $this->item->getByOpenItemId($event->getId());
        $recipient = $this->user->getById($item->user_id);
        $sender    = $this->user->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif ($this->notificationIsEnabled('good', $recipient->id)) {
            return false;
        }

        $this->mail->send(
            'emails.action.good',
            $this->getDataForMail($item, $recipient, $sender),
            function ($m) use ($recipient, $sender) {
                $m->to($recipient->email)
                    ->subject($sender->username.'さんからいいねがつきました - Owl');
            }
        );
    }

    /**
     * 記事がお気に入りされた時
     *
     * @param FavoriteEvent  $event
     */
    public function onGetFavorite(FavoriteEvent $event)
    {
        $item      = $this->item->getByOpenItemId($event->getId());
        $recipient = $this->user->getById($item->user_id);
        $sender    = $this->user->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif ($this->notificationIsEnabled('favorite', $recipient->id)) {
            return false;
        }

        $this->mail->send(
            'emails.action.favorite',
            $this->getDataForMail($item, $recipient, $sender),
            function ($m) use ($recipient, $sender) {
                $m->to($recipient->email)
                    ->subject($sender->username.'さんに記事がお気に入りされました - Owl');
            }
        );
    }

    /**
     * 記事が編集された時
     *
     * @param EditEvent  $event
     */
    public function onItemEdited(EditEvent $event)
    {
        $item      = $this->item->getByOpenItemId($event->getId());
        $recipient = $this->user->getById($item->user_id);
        $sender    = $this->user->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif ($this->notificationIsEnabled('edit', $recipient->id)) {
            return false;
        }

        $this->mail->send(
            'emails.action.edit',
            $this->getDataForMail($item, $recipient, $sender),
            function ($m) use ($recipient, $sender) {
                $m->to($recipient->email)
                    ->subject('あなたの記事が'.$sender->username.'さんに編集されました - Owl');
            }
        );
    }

    /**
     * 各イベントにハンドラーメソッドを登録
     *
     * @param \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $subscriberName = '\Owl\Handlers\Events\EmailNotification';

        $events->listen(CommentEvent::class,  $subscriberName.'@onGetComment');
        $events->listen(GoodEvent::class,     $subscriberName.'@onGetGood');
        $events->listen(FavoriteEvent::class, $subscriberName.'@onGetFavorite');
        $events->listen(EditEvent::class,     $subscriberName.'@onItemEdited');
    }

    /**
     * 通知設定をONにしてるかどうかチェックする
     *
     * @param string  $type
     * @param int     $userId
     *
     * @return bool
     */
    protected function notificationIsEnabled($type, $userId)
    {
        $colomnName = $type.'_notification_flag';
        $flags = (array) $this->mailNotification->get($userId);
        return !!$flags[$colomnName];
    }

    /**
     * 通知を発生させたユーザと通知を受け取るユーザが同じかチェックする
     *
     * @parma object  $recipient
     * @param object  $sender
     *
     * @return bool
     */
    protected function areUsersSame($recipient, $sender)
    {
        return $recipient->id === $sender->id;
    }

    /**
     * Mail View用の基本データを取得
     *
     * @param object  $item
     * @param object  $recipient
     * @param object  $sender
     *
     * @return array
     */
    protected function getDataForMail($item, $recipient, $sender)
    {
        return [
            'recipient' => $recipient->username,
            'sender'    => $sender->username,
            'itemId'    => $item->open_item_id,
            'itemTitle' => $item->title,
        ];
    }
}
