<?php

class RepositoryProviderTest extends \TestCase
{
    /**
     * Repositoryクラスがサービスコンテナに正常に登録されているかテスト
     */
    public function testValidInstance()
    {
        $userMailNotification =
            $this->app->make($this->userMailNotifyRepoName);
        $this->assertInstanceOf(
            $this->userMailNotifyRepoName,
            $userMailNotification
        );
    }
}
