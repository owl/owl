<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When I logged in
     */
    public function iLoggedIn()
    {
        $this->visitPath('/login');
        $this->fillField('username', 'admin');
        $this->fillField('password', 'password');
        $this->pressButton('ログイン');
    }

    /**
     * @When I create random user
     */
    public function iCreateRandomUser()
    {
        $this->visitPath('/signup');
        $testUsername = $this->makeRandStr();
        $this->fillField('username', $testUsername);
        $testEmail  = $testUsername . "@example.com";
        $this->fillField('email', $testEmail);
        $this->fillField('password', 'password');
        $this->pressButton('登録');
    }

    /**
     * @When I delete item
     */
    public function iDeleteItem()
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('css',"#item-delete");
        $element->click();
    }

    /**
     * ランダム文字列生成 (英数字)
     * @param int $length 
     * @return string
     */
    public function makeRandStr($length = 8) {
        static $chars = 'abcdefghijklmnopqrstuvwxyz';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= $chars[mt_rand(0, 25)];
        }
        return $str;
    }
}
