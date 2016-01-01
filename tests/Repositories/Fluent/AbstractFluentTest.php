<?php

class AbstractFluentTest extends \TestCase
{
    public function testShouldGetQueryBuilder()
    {
        $mockRepo = $this->app->make('MockAbstractFluent');
        $builderMethod = $this->getProtectMethod($mockRepo, 'builder');
        $this->assertInstanceOf(
            'Illuminate\Database\Query\Builder',
            $builderMethod->invoke($mockRepo)
        );
    }
}

class MockAbstractFluent extends \Owl\Repositories\Fluent\AbstractFluent
{
    public function getTableName()
    {
        return 'testTable';
    }
}
