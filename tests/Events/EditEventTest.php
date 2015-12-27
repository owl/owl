<?php

use Owl\Events\Item\EditEvent;

class EditEventTest extends \TestCase
{
    public function testValidInstance()
    {
        $event = new EditEvent('itemId', 'userId');
        $this->assertInstanceOf('Owl\Events\Item\EditEvent', $event);
    }
}
