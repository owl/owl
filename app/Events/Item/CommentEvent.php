<?php namespace Owl\Events\Item;

/**
 * @copyright (c) owl
 */

use Owl\Events\Item\BaseItemEvent;

/**
 * Class CommentEvent
 * 記事へのコメントのイベントクラス
 *
 * @package Owl\Events\Item
 */
class CommentEvent extends BaseItemEvent {

    /** @var string */
    protected $comment;

    /**
     * Create a new event instance.
     *
     * @param string  $itemId
     * @param string  $userId
     * @param string  $comment
     */
    public function __construct($itemId, $userId, $comment)
    {
        parent::__construct($itemId, $userId);
        $this->comment = $comment;
    }

    /**
     * Get text of comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
