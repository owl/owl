<?php

use Mockery as m;
use Mockery\MockInterface as i;
use Illuminate\Database\DatabaseManager;
use Owl\Services\UserService;

class UserServiceTest extends \TestCase
{
    /** @var string */
    protected $serviceName   = 'Owl\Services\UserService';

    public function testValidInstance()
    {
        $service = $this->app->make($this->serviceName);
        $this->assertInstanceOf(
            $this->serviceName, $service
        );
    }

    public function testGetUserMethod()
    {
        \DB::shouldReceive('table->where->first')->andReturn('user');
        $service = $this->app->make($this->serviceName);

        $this->assertEquals('user', $service->getUser([]));
    }
}
