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
     * @param int  $itemId
     * @param int  $userId
     */
    public function __construct($itemId, $userId)
    {
        $this->itemId = $itemId;
        $this->userId = $userId;
    }

    /**
     * Get ID of item
     *
     * @return int
     */
    public function getId()
    {
        return $this->itemId;
    }

    /**
     * Get ID of user who actions
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
