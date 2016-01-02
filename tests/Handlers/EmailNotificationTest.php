<?php

use Mockery as m;
use Illuminate\Contracts\Mail\Mailer;
use Owl\Handlers\Events\EmailNotification;
use Owl\Events\Item\CommentEvent;
use Owl\Events\Item\LikeEvent;
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

        // mock data
        $this->dummyItem = (object) [
            'open_item_id' => 'open_item_id',
            'title'        => 'title',
            'user_id'      => 'user_id',
        ];
        $this->dummyRecipient = (object) [
            'id'       => 'recipient_id',
            'username' => 'recipient',
            'email'    => 'recipient@test.com',
        ];
        $this->dummySender = (object) [
            'id'       => 'sender_id',
            'username' => 'sender',
        ];
        $this->dummyFlags = (object) [
            'comment_notification_flag'  => 1,
            'good_notification_flag'     => 1,
            'favorite_notification_flag' => 1,
            'edit_notification_flag'     => 1,
        ];
        // mock class
        $this->userRepo = m::mock($this->userRepoName);
        $this->itemRepo = m::mock($this->itemRepoName);
        $this->mailRepo = m::mock($this->userMailNotifyRepoName);
    }

    public function testValidInstance()
    {
        $handler = $this->app->make($this->handlerName);
        $this->assertInstanceOf($this->handlerName, $handler);
    }

    public function testShouldReturnFalseWhenSelfAction()
    {
        $this->dummySender->id = 'recipient_id';
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $handler = new EmailNotification(
            $this->app->make('Illuminate\Contracts\Mail\Mailer'),
            $this->itemRepo, $this->userRepo, $this->mailRepo
        );
        // assertion
        $commentEvent = new CommentEvent('itemId', 'userId', 'comment');
        $this->assertFalse($handler->onGetComment($commentEvent));
        $goodEvent = new LikeEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetLike($goodEvent));
        $favoriteEvent = new FavoriteEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetFavorite($favoriteEvent));
        $editEvent = new EditEvent('itemId', 'userId');
        $this->assertFalse($handler->onItemEdited($editEvent));
    }

    public function testShouldReturnFalseWhenFlagIsFalse()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('get')->andReturn((object) [
            'comment_notification_flag'  => 0,
            'good_notification_flag'     => 0,
            'favorite_notification_flag' => 0,
            'edit_notification_flag'     => 0,
        ]);
        $handler = new EmailNotification(
            $this->app->make('Illuminate\Contracts\Mail\Mailer'),
            $this->itemRepo, $this->userRepo, $this->mailRepo
        );
        // assertion
        $commentEvent = new CommentEvent('itemId', 'userId', 'comment');
        $this->assertFalse($handler->onGetComment($commentEvent));
        $goodEvent = new LikeEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetLike($goodEvent));
        $favoriteEvent = new FavoriteEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetFavorite($favoriteEvent));
        $editEvent = new EditEvent('itemId', 'userId');
        $this->assertFalse($handler->onItemEdited($editEvent));
    }

    public function testShouldCommentNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('get')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        // TODO: test mail content

        $handler = new EmailNotification(
            $mailerMock, $this->itemRepo, $this->userRepo, $this->mailRepo
        );
        $commentEvent = new CommentEvent('itemId', 'userId', 'comment');
        $handler->onGetComment($commentEvent);
    }

    public function testShouldLikeNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('get')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        // TODO: test mail content

        $handler = new EmailNotification(
            $mailerMock, $this->itemRepo, $this->userRepo, $this->mailRepo
        );
        $commentEvent = new LikeEvent('itemId', 'userId');
        $handler->onGetLike($commentEvent);
    }

    public function testShouldFavoriteNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('get')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        // TODO: test mail content

        $handler = new EmailNotification(
            $mailerMock, $this->itemRepo, $this->userRepo, $this->mailRepo
        );
        $commentEvent = new FavoriteEvent('itemId', 'userId');
        $handler->onGetFavorite($commentEvent);
    }

    public function testShouldItemEditNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('get')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        // TODO: test mail content

        $handler = new EmailNotification(
            $mailerMock, $this->itemRepo, $this->userRepo, $this->mailRepo
        );
        $commentEvent = new EditEvent('itemId', 'userId');
        $handler->onItemEdited($commentEvent);
    }
}
