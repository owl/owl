<?php

/**
 * @copyright (c) owl
 */

namespace Owl\Events\Item;

use Illuminate\Queue\SerializesModels;
use Owl\Events\Event;

/**
 * Class BaseEventItem
 * 記事関連イベントの共通メソッド等をまとめる
 *
 * @package Owl\Events\Item
 */
class BaseItemEvent extends Event {

    use SerializesModels;

    /** @var string */
    protected $itemId;

    /**
     * Create a new event instance.
     *
     * @param string  $itemId
     */
    public function __construct($itemId)
    {
        $this->itemId = $itemId;
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
}
