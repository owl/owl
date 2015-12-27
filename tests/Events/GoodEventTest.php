<?php

use Owl\Events\Item\GoodEvent;

class GoodEventTest extends \TestCase
{
    public function testValidInstance()
    {
        $event = new GoodEvent('itemId', 'userId');
        $this->assertInstanceOf('Owl\Events\Item\GoodEvent', $event);
    }
}
