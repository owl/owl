<?php namespace Owl\Events\Item;

/**
 * @copyright (c) owl
 */

use Illuminate\Queue\SerializesModels;
use Owl\Events\Event;

/**
 * Class BaseEventItem
 * 記事関連イベントの共通メソッド等をまとめる
 *
 * @package Owl\Events\Item
 */
class BaseItemEvent extends Event
{
    use SerializesModels;

    /** @var string */
    protected $itemId;

    /** @var string */
    protected $userId;

    /**
     * Create a new event instance.
     *
     * @param string  $itemId
     * @param string  $userId
     */
    public function __construct($itemId, $userId)
    {
        $this->itemId = $itemId;
        $this->userId = $userId;
    }

    /**
     * Get ID of item
     *
     * @return string
     */
    public function getId()
    {
        return $this->itemId;
    }

    /**
     * Get ID of user who actions
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
