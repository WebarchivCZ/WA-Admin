<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class Example extends PHPUnit_Extensions_SeleniumTestCase
{
    function setUp()
    {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://localhost/");
    $this->waitForPageToLoad("5000");
    $this->open("http://localhost/wadmin/index.php/login");
        $this->type("username", "sibek");
        $this->type('password', 'test');
        $this->click("remember");
        $this->click("přihlásit");
        $this->waitForPageToLoad("30000");
    }

    function testMyTestCase()
    {
        $this->open("/wadmin/index.php/tables/ratings/view/12");
        try
        {
            $this->assertTrue($this->isTextPresent("-1"));
        } catch (PHPUnit_Framework_AssertionFailedError $e)
        {
            array_push($this->verificationErrors, $e->toString());
        }
    }
}
?>