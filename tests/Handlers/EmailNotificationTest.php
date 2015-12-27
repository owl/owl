<?php

use Mockery as m;
use Illuminate\Contracts\Mail\Mailer;
use Owl\Handlers\Events\EmailNotification;
use Owl\Events\Item\CommentEvent;
use Owl\Events\Item\GoodEvent;
use Owl\Events\Item\FavoriteEvent;
use Owl\Events\Item\EditEvent;

class EmailNotificationTest extends \TestCase
{
    /** @var string */
    protected $handlerName = 'Owl\Handlers\Events\EmailNotification';
    protected $testLogPath = 'tests/storage/logs/notify.log';

    public function setUp()
    {
        parent::setUp();

        $this->registerTestLogger();
        \Log::useFiles(base_path($this->testLogPath));
        // mock data
        $this->dummyItem = (object) [
            'open_item_id' => 'open_item_id',
            'title'        => 'title',
            'user_id'      => 'user_id',
        ];
        $this->dummyRecipient = (object) [
            'id'       => 'recipient_id',
            'username' => 'recipient',
            'email'    => 'email',
        ];
        $this->dummySender = (object) [
            'id'       => 'sender_id',
            'username' => 'sender',
        ];
        // mock class
        $this->userRepo = m::mock($this->userRepoName);
        $this->itemRepo = m::mock($this->itemRepoName);
    }

    public function tearDown()
    {
        parent::tearDown();
        //\File::delete(base_path($this->testLogPath));
    }

    public function testValidInstance()
    {
        $handler = $this->app->make($this->handlerName);
        $this->assertInstanceOf($this->handlerName, $handler);
    }

    public function testShouldReturnFalse()
    {
        $this->dummySender->id = 'recipient_id';
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $handler = new EmailNotification(
            $this->app->make(Mailer::class),
            $this->itemRepo, $this->userRepo
        );
        // assertion
        $commentEvent = new CommentEvent('itemId', 'userId', 'comment');
        $this->assertFalse($handler->onGetComment($commentEvent));
        $goodEvent = new GoodEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetGood($goodEvent));
        $favoriteEvent = new FavoriteEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetFavorite($favoriteEvent));
        $editEvent = new EditEvent('itemId', 'userId');
        $this->assertFalse($handler->onItemEdited($editEvent));
    }
}
