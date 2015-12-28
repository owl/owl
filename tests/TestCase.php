<?php

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /** @var string リポジトリクラスのサービスコンテナへの登録名 */
    protected $userRepoName = 'Owl\Repositories\UserRepositoryInterface';
    protected $itemRepoName = 'Owl\Repositories\ItemRepositoryInterface';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    /**
     * @param $class
     * @param $name
     *
     * @return \ReflectionMethod
     */
    protected function getProtectMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * @param $class
     * @param $name
     *
     * @return \ReflectionProperty
     */
    protected function getProtectProperty($class, $name)
    {
        $class = new \ReflectionClass($class);
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        return $property;
    }

    /**
     * テスト用Logファサードをサービスコンテナに登録
     */
    protected function registerTestLogger()
    {
        $this->app->bind('log', function ($app) {
            $logger = new \Illuminate\Log\Writer(
                new \Monolog\Logger('testing'), $app['events']
            );
            (new \Illuminate\Foundation\Bootstrap\ConfigureLogging)
                ->bootstrap($app);
            return $logger;
        });
    }
}
