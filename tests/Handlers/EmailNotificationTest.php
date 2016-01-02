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
            'like_notification_flag'     => 1,
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
        $this->bindReposHelper($this->itemRepo, $this->userRepo, $this->mailRepo);
        $handler = $this->app->make($this->handlerName);
        // assertion
        $commentEvent = new CommentEvent('itemId', 'userId', 'comment');
        $this->assertFalse($handler->onGetComment($commentEvent));
        $likeEvent = new LikeEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetLike($likeEvent));
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
        $this->mailRepo->shouldReceive('getByUserId')->andReturn((object) [
            'comment_notification_flag'  => 0,
            'like_notification_flag'     => 0,
            'favorite_notification_flag' => 0,
            'edit_notification_flag'     => 0,
        ]);
        $this->bindReposHelper($this->itemRepo, $this->userRepo, $this->mailRepo);
        $handler = $this->app->make($this->handlerName);
        // assertion
        $commentEvent = new CommentEvent('itemId', 'userId', 'comment');
        $this->assertFalse($handler->onGetComment($commentEvent));
        $likeEvent = new LikeEvent('itemId', 'userId');
        $this->assertFalse($handler->onGetLike($likeEvent));
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
        $this->mailRepo->shouldReceive('getByUserId')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        $this->app->bind('Illuminate\Contracts\Mail\Mailer', function ($app) use ($mailerMock) {
            return $mailerMock;
        });
        $this->bindReposHelper($this->itemRepo, $this->userRepo, $this->mailRepo);
        $handler = $this->app->make($this->handlerName);

        // TODO: test mail content
        $commentEvent = new CommentEvent('itemId', 'userId', 'comment');
        $handler->onGetComment($commentEvent);
    }

    public function testShouldLikeNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('getByUserId')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        $this->app->bind('Illuminate\Contracts\Mail\Mailer', function ($app) use ($mailerMock) {
            return $mailerMock;
        });
        $this->bindReposHelper($this->itemRepo, $this->userRepo, $this->mailRepo);
        $handler = $this->app->make($this->handlerName);

        // TODO: test mail content
        $commentEvent = new LikeEvent('itemId', 'userId');
        $handler->onGetLike($commentEvent);
    }

    public function testShouldFavoriteNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('getByUserId')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        $this->app->bind('Illuminate\Contracts\Mail\Mailer', function ($app) use ($mailerMock) {
            return $mailerMock;
        });
        $this->bindReposHelper($this->itemRepo, $this->userRepo, $this->mailRepo);
        $handler = $this->app->make($this->handlerName);

        // TODO: test mail content
        $commentEvent = new FavoriteEvent('itemId', 'userId');
        $handler->onGetFavorite($commentEvent);
    }

    public function testShouldItemEditNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->dummyItem);
        $this->userRepo->shouldReceive('getById')
            ->times(2)->andReturn($this->dummyRecipient, $this->dummySender);
        $this->mailRepo->shouldReceive('getByUserId')->andReturn($this->dummyFlags);
        $mailerMock = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailerMock->shouldReceive('send')->andReturn(null);
        $this->app->bind('Illuminate\Contracts\Mail\Mailer', function ($app) use ($mailerMock) {
            return $mailerMock;
        });
        $this->bindReposHelper($this->itemRepo, $this->userRepo, $this->mailRepo);
        $handler = $this->app->make($this->handlerName);

        // TODO: test mail content
        $commentEvent = new EditEvent('itemId', 'userId');
        $handler->onItemEdited($commentEvent);
    }

    /**
     * EmailNotificationのインスタンス生成に必要なリポジトリをbind
     *
     * @param i  $itemRepo
     * @param i  $userRepo
     * @param i  $mailRepo
     */
    protected function bindReposHelper($itemRepo, $userRepo, $mailRepo)
    {
        $this->app->bind($this->itemRepoName, function ($app) use ($itemRepo) {
            return $itemRepo;
        });
        $this->app->bind($this->userRepoName, function ($app) use ($userRepo) {
            return $userRepo;
        });
        $this->app->bind($this->userMailNotifyRepoName, function ($app) use ($mailRepo) {
            return $mailRepo;
        });
    }
}
