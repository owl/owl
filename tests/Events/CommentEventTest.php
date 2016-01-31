<?php

use Owl\Events\Item\CommentEvent;

class CommentEventTest extends \TestCase
{
    public function testValidInstance()
    {
        $event = new CommentEvent('itemId', 'userId', 'comment');
        $this->assertInstanceOf('Owl\Events\Item\CommentEvent', $event);
    }

    public function testShouldReturnComment()
    {
        $expectedComment = 'comment';
        $event = new CommentEvent('itemId', 'userId', $expectedComment);
        $this->assertEquals($expectedComment, $event->getComment());
    }
}
