<?php

use Owl\Events\Item\LikeEvent;

class LikeEventTest extends \TestCase
{
    public function testValidInstance()
    {
        $event = new LikeEvent('itemId', 'userId');
        $this->assertInstanceOf('Owl\Events\Item\LikeEvent', $event);
    }
}
