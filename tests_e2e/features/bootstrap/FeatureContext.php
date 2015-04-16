<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $base_url;
    private $status;
    private $response;
    private $contentType;
    private $postParams = array();

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(array $parameters)
    {
        $this->base_url = $parameters['base_url'];
    }

    /**
     * @When /^I send a GET request to "([^"]*)"$/
     */
    public function iSendAGetRequestTo($arg1)
    {
        $url = $this->base_url."$arg1";
        $curl = curl_init($url);
        $options = array(
          CURLOPT_HTTPHEADER     => array(),
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_HTTPGET        => true,
          CURLOPT_RETURNTRANSFER => true
        );
 
        curl_setopt_array($curl, $options);
        $this->response    = curl_exec($curl);
        $this->status      = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
    }

    /**
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        if($this->status !== intval($arg1)){
            throw new Exception("Actual status code was => ".$this->status);
        }
    }

   /**
     * @When /^I send a POST request to "([^"]*)"$/
     */
    public function iSendAPostRequestTo($arg1)
    {
        $fields_string = "";
        foreach($this->postParams as $key=>$value) { 
            if(is_array($value)){
                foreach($value as $val){
                    $fields_string .= $key.'[]='.$val.'&';
                }
            }else{
                $fields_string .= $key.'='.$value.'&';
            }
        }
        $url = $this->base_url."$arg1";
        $curl = curl_init($url);
        $options = array(
          CURLOPT_HTTPHEADER     => array(),
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST           => true,
          CURLOPT_POSTFIELDS     => $fields_string
        );
 
        curl_setopt_array($curl, $options);
        $this->response    = curl_exec($curl);
        $this->status      = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
    }

    /**
     * @When /^I set a POST parameter "([^"]*)" to "([^"]*)"$/
     */
    public function iSetAPostParameterTo($arg1, $arg2)
    {
        $ps = explode(',', $arg2);
        $this->postParams[$arg1] = count($ps) > 1 ? $ps : $arg2;
    }

    /**
     * @Then /^the response content type should be "([^"]*)"$/
     */
    public function theResponseContentTypeShouldBe($arg1)
    {
        if($this->contentType !== (String)($arg1)){
            throw new Exception("Actual contentType was => ".$this->contentType);
        }
    }
}
