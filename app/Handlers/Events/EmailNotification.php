<?php namespace Owl\Handlers\Events;

/**
 * @copyright (c) owl
 */

use Illuminate\Contracts\Mail\Mailer;
use Owl\Events\Item\CommentEvent;
use Owl\Events\Item\LikeEvent;
use Owl\Events\Item\FavoriteEvent;
use Owl\Events\Item\EditEvent;
use Owl\Services\ItemService;
use Owl\Services\UserService;
use Owl\Services\MailNotifyService;

/**
 * Class EmailNotification
 * メール送信関連のイベントハンドラークラス
 *
 * @package Owl\Handlers\Events
 */
class EmailNotification
{
    /** @var Mailer */
    protected $mail;

    /** @var ItemService */
    protected $itemService;

    /** @var UserService */
    protected $userService;

    /** @var MailNotifyService */
    protected $mailNotifyService;

    /**
     * @param Mailer             $mailer
     * @param ItemService        $itemService
     * @param UserService        $userService
     * @param MailNotifyService  $mailNotifyService
     */
    public function __construct(
        Mailer            $mailer,
        ItemService       $itemService,
        UserService       $userService,
        MailNotifyService $mailNotifyService
    ) {
        $this->mail              = $mailer;
        $this->itemService       = $itemService;
        $this->userService       = $userService;
        $this->mailNotifyService = $mailNotifyService;
    }

    /**
     * 記事にコメントがついた時のメール通知
     *
     * @param CommentEvent  $event
     */
    public function onGetComment(CommentEvent $event)
    {
        $item      = $this->itemService->getByOpenItemId($event->getId());
        $recipient = $this->userService->getById($item->user_id);
        $sender    = $this->userService->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif (!$this->notificationIsEnabled('comment', $recipient->id)) {
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
     * @param LikeEvent  $event
     */
    public function onGetLike(LikeEvent $event)
    {
        $item      = $this->itemService->getByOpenItemId($event->getId());
        $recipient = $this->userService->getById($item->user_id);
        $sender    = $this->userService->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif (!$this->notificationIsEnabled('like', $recipient->id)) {
            return false;
        }

        $this->mail->send(
            'emails.action.like',
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
        $item      = $this->itemService->getByOpenItemId($event->getId());
        $recipient = $this->userService->getById($item->user_id);
        $sender    = $this->userService->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif (!$this->notificationIsEnabled('favorite', $recipient->id)) {
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
        $item      = $this->itemService->getByOpenItemId($event->getId());
        $recipient = $this->userService->getById($item->user_id);
        $sender    = $this->userService->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        } elseif (!$this->notificationIsEnabled('edit', $recipient->id)) {
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
        $eventBaseName  = '\Owl\Events\Item';

        $events->listen($eventBaseName.'\CommentEvent',  $subscriberName.'@onGetComment');
        $events->listen($eventBaseName.'\LikeEvent',     $subscriberName.'@onGetLike');
        $events->listen($eventBaseName.'\FavoriteEvent', $subscriberName.'@onGetFavorite');
        $events->listen($eventBaseName.'\EditEvent',     $subscriberName.'@onItemEdited');
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
        $flags = (array) $this->mailNotifyService->getSettings($userId);
        return !!$flags[$colomnName];
    }

    /**
     * 通知を発生させたユーザと通知を受け取るユーザが同じかチェックする
     *
     * @parma \stdclass  $recipient
     * @param \stdclass  $sender
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
     * @param \stdclass  $item
     * @param \stdclass  $recipient
     * @param \stdclass  $sender
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
