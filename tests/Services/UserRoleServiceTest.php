<?php

use Mockery as m;
use MockeryInterface as i;
use Owl\Services\UserRoleService;

class UserRoleServiceTest extends \TestCase
{
    /** @var i */
    protected $userRoleCriteria;

    /** @var string */
    protected $serviceName = 'Owl\Services\UserRoleService';

    public function setUp()
    {
        parent::setUp();

        $this->userRoleCriteria = m::mock($this->userRoleRepoName);
    }

    public function testValidInstance()
    {
        $service = $this->app->make($this->serviceName);
        $this->assertInstanceOf(
            $this->serviceName, $service
        );
    }

    public function testShouldReturnAllData()
    {
        $this->userRoleCriteria->shouldReceive('getAll')->andReturn([]);
        $service = new UserRoleService($this->userRoleCriteria);
        $this->assertEquals([], $service->getAll());
    }

    public function testShouldReturnRecord()
    {
        $this->userRoleCriteria->shouldReceive('getByUserId')->andReturn('user data');
        $service = new UserRoleService($this->userRoleCriteria);
        $this->assertEquals('user data', $service->getByUserId(1235));
    }

    public function testShouldReturnNullInsteadOfRecord()
    {
        $this->userRoleCriteria->shouldReceive('getByUserId')->andReturn(null);
        $service = new UserRoleService($this->userRoleCriteria);
        $this->assertNull($service->getByUserId(1235));
    }
}
