<?php

use Mockery as m;
use Owl\Services\MailNotifyService;

class MailNotifyServiceTest extends \TestCase
{
    /** @var i */
    protected $userMailNotifyCriteria;

    public function setUp()
    {
        parent::setUp();

        $this->userMailNotifyCriteria = m::mock($this->userMailNotifyRepoName);
    }

    public function testValidInstance()
    {
        $serviceName = 'Owl\Services\MailNotifyService';
        $service = $this->app->make($serviceName);
        $this->assertInstanceOf(
            $serviceName, $service
        );
    }

    public function testShouldReturnSettings()
    {
        $this->userMailNotifyCriteria->shouldReceive('get')->andReturn('mockData');
        $service = new MailNotifyService($this->userMailNotifyCriteria);
        $this->assertEquals('mockData', $service->getSettings(1235));
    }

    public function testShouldReturnUpdateResult()
    {
        $this->userMailNotifyCriteria->shouldReceive('update')->andReturn(true);
        $service = new MailNotifyService($this->userMailNotifyCriteria);
        $this->assertTrue($service->updateSettings(1235, []));
    }
}
