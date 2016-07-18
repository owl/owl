<?php

use Mockery as m;
use MockeryInterface as i;
use Owl\Handlers\Events\SlackNotification;
use Owl\Events\Item\CreateEvent;
use Owl\Events\Item\EditEvent;
use Owl\Libraries\SlackUtils;

class SlackNotificationTest extends \TestCase
{
    /** @var string */
    protected $handlerName = 'Owl\Handlers\Events\SlackNotification';

    /** @var i */
    protected $itemRepo;

    /** @var i */
    protected $userRepo;

    /** @var SlackNotification */
    protected $handler;

    public function setUp()
    {
        parent::setUp();

        $this->dummyUser = (object) [
            'id'       => 'sender_id',
            'username' => 'sender',
        ];
        // mock class
        $this->itemRepo      = m::mock($this->itemRepoName);
        $this->userRepo      = m::mock($this->userRepoName);
        $this->slackUtilMock = m::mock('Owl\Libraries\SlackUtils');

        $this->app->bind($this->itemRepoName, function ($app) {
            return $this->itemRepo;
        });
        $this->app->bind($this->userRepoName, function ($app) {
            return $this->userRepo;
        });
        $this->app->bind('Owl\Libraries\SlackUtils', function ($app) {
            return $this->slackUtilMock;
        });

        $this->handler = $this->app->make($this->handlerName);
    }

    public function testValidInstance()
    {
        $this->assertInstanceOf($this->handlerName, $this->handler);
    }

    public function testShouldItemCreateNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->createMockItem());
        $this->userRepo->shouldReceive('getById')->andReturn($this->dummyUser);
        $this->slackUtilMock->shouldReceive('postCreateMessage')->once()->andReturn(true);

        $createEvent = new CreateEvent('itemId', 'userId');
        $this->handler->onItemCreated($createEvent);
    }

    public function testShouldItemEditNotify()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->createMockItem());
        $this->userRepo->shouldReceive('getById')->andReturn($this->dummyUser);
        $this->slackUtilMock->shouldReceive('postEditMessage')->once()->andReturn(true);

        $editEvent = new EditEvent('itemId', 'userId');
        $this->handler->onItemEdited($editEvent);
    }

    /**
     * 非公開記事は通知されない
     */
    public function testShouldNotNotifyWhenItemIsNotPublished()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->createMockItem("0"));
        $this->userRepo->shouldReceive('getById')->andReturn($this->dummyUser);
        $this->slackUtilMock->shouldNotReceive('postEditMessage');
        $this->slackUtilMock->shouldNotReceive('postCreateMessage');

        $editEvent = new EditEvent('itemId', 'userId');
        $this->handler->onItemEdited($editEvent);

        $createEvent = new CreateEvent('itemId', 'userId');
        $this->handler->onItemCreated($createEvent);
    }

    /**
     * 限定公開記事は通知されない
     */
    public function testShouldNotNotifyWhenItemIsNotPublishedAndLimitation()
    {
        $this->itemRepo->shouldReceive('getByOpenItemId')->andReturn($this->createMockItem("1"));
        $this->userRepo->shouldReceive('getById')->andReturn($this->dummyUser);
        $this->slackUtilMock->shouldNotReceive('postEditMessage');
        $this->slackUtilMock->shouldNotReceive('postCreateMessage');

        $editEvent = new EditEvent('itemId', 'userId');
        $this->handler->onItemEdited($editEvent);

        $createEvent = new CreateEvent('itemId', 'userId');
        $this->handler->onItemCreated($createEvent);
    }

    /**
     * モック用記事データを返す
     *
     * @param string  $published
     *
     * @return \stdClass
     */
    protected function createMockItem($published = "2")
    {
        return (object) [
            'open_item_id' => 'open_item_id',
            'title'        => 'title',
            'user_id'      => 'user_id',
            'published'    => $published,
        ];
    }
}
