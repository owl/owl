<?php

use Owl\Events\Item\FavoriteEvent;

class FavoriteEventTest extends \TestCase
{
    public function testValidInstance()
    {
        $event = new FavoriteEvent('itemId', 'userId');
        $this->assertInstanceOf('Owl\Events\Item\FavoriteEvent', $event);
    }
}
