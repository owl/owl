<?php

use Mockery as m;
use Owl\Services\MailNotifyService;

class MailNotifyServiceTest extends \TestCase
{
    /** @var i */
    protected $userMailNotifyCriteria;

    /** @var string */
    protected $serviceName = 'Owl\Services\MailNotifyService';

    public function setUp()
    {
        parent::setUp();

        $this->userMailNotifyCriteria = m::mock($this->userMailNotifyRepoName);
    }

    public function testValidInstance()
    {
        $service = $this->app->make($this->serviceName);
        $this->assertInstanceOf(
            $this->serviceName, $service
        );
    }

    public function testShouldReturnSettings()
    {
        $this->userMailNotifyCriteria->shouldReceive('get')->andReturn('mockData');
        $service = new MailNotifyService($this->userMailNotifyCriteria);
        $this->assertEquals('mockData', $service->getSettings(1235));
    }

    public function testShouldInsertAndReturnSettings()
    {
        $this->userMailNotifyCriteria->shouldReceive('get')->
            times(2)->andReturn(null, 'mockData');
        $this->userMailNotifyCriteria->shouldReceive('insert')->andReturn(null);
        $service = new MailNotifyService($this->userMailNotifyCriteria);
        $this->assertEquals('mockData', $service->getSettings(1235));
    }

    public function testShouldReturnUpdateResult()
    {
        $this->userMailNotifyCriteria->shouldReceive('update')->andReturn(true);
        $service = new MailNotifyService($this->userMailNotifyCriteria);
        $this->assertTrue($service->updateSetting(1235, 'comment', 0));
    }

    /**
     * @dataProvider getTypes
     */
    public function testShouldReturnValidColumnNames($type, $expected)
    {
        $service = $this->app->make($this->serviceName);
        $protectMethod = $this->getProtectMethod($service, 'getFlagColomunName');
        $this->assertEquals(
            $expected, $protectMethod->invoke($service, $type)
        );
    }

    public function testShouldReturnDefaultColomuns()
    {
        $service = $this->app->make($this->serviceName);
        $protectMethod = $this->getProtectMethod($service, 'getDefaultColomuns');
        $mockUserId = 1235;
        $this->assertEquals(
            [
                'user_id'                    => $mockUserId,
                'comment_notification_flag'  => 0,
                'favorite_notification_flag' => 0,
                'good_notification_flag'     => 0,
                'edit_notification_flag'     => 0,
            ],
            $protectMethod->invoke($service, $mockUserId)
        );
    }

    /**
     * for testShouldReturnValidColumnNames
     *
     * @return array
     */
    public function getTypes()
    {
        return [
            ['comment',  'comment_notification_flag'],
            ['favorite', 'favorite_notification_flag'],
            ['good',     'good_notification_flag'],
            ['edit',     'edit_notification_flag'],
        ];
    }
}
