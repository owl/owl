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

    public function testIsRetireShouldReturnTrue()
    {
        $this->userRoleCriteria->shouldReceive('getByUserId')->andReturn((object) [
            'name' => '退会済み',
        ]);
        $service = new UserRoleService($this->userRoleCriteria);
        $this->assertTrue($service->isRetire(1235));
    }

    public function testIsRetireShouldReturnFalse()
    {
        $this->userRoleCriteria->shouldReceive('getByUserId')->andReturn(null);
        $service = new UserRoleService($this->userRoleCriteria);
        $this->assertFalse($service->isRetire(1235));

        $this->userRoleCriteria->shouldReceive('getByUserId')->andReturn((object) [
            'name' => 'オーナー',
        ]);
        $service = new UserRoleService($this->userRoleCriteria);
        $this->assertFalse($service->isRetire(1235));
    }
}
