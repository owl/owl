<?php

/**
 * @copyright (c) owl
 */
namespace Owl\Handlers\Events;

use Owl\Events\Item\CommentEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Contracts\Mail\Mailer;

/**
 * Class EmailNotification
 *
 * @package Owl\Handlers\Events
 */
class EmailNotification {
    /** @var Mailer */
    protected $mail;

    /**
     * @param Mailer  $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mail = $mailer;
    }

    /**
     * 記事にコメントがついた際
     *
     * @param CommentEvent  $event
     */
    public function onGetComment(CommentEvent $event)
    {
        // TODO: コメントメール送信
    }

    /**
     * 記事にいいね！がついた時
     *
     * @param mixed $event
     */
    public function onGetGood($event)
    {
        // TODO: いいねメール送信
    }

    /**
     * 記事がストックされた時
     *
     * @param mixed $event
     */
    public function onGetStock($event)
    {
        // TODO: ストックメール送信
    }

    /**
     * 記事が編集された時
     *
     * @param mixed $event
     */
    public function onItemEdited($event)
    {
        // TODO: 記事編集通知送信
    }

    /**
     * 各イベントにハンドラーメソッドを登録
     *
     * @param \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $subscriberName = '\Owl\Handlers\Events\EmailNotification';

        $events->listen(CommentEvent::class, $subscriberName.'@onGetComment');
        $events->listen('event.item.good',   $subscriberName.'@onGetGood');
        $events->listen('event.item.stock',  $subscriberName.'@onGetStock');
        $events->listen('event.item.edit',   $subscriberName.'@onItemEdited');
    }
}
