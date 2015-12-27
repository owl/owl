<?php

use Owl\Events\Item\BaseItemEvent;

class BaseItemEventTest extends \TestCase
{
    public function testValidInstance()
    {
        $event = new BaseItemEvent('itemId', 'userId');
        $this->assertInstanceOf('Owl\Events\Item\BaseItemEvent', $event);
    }

    public function testShouldReturnId()
    {
        $expectedItemId = 'itemId';
        $expectedUserId = 'userId';
        $event = new BaseItemEvent($expectedItemId, $expectedUserId);
        $this->assertEquals($expectedItemId, $event->getId());
        $this->assertEquals($expectedUserId, $event->getUserId());
    }
}
