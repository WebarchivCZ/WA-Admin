<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class basicFunctionalityTest extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://localhost/");
  }

  public function login()
    {
        $this->open("http://localhost/wadmin/index.php/login");
        $this->type("username", "sibek");
        $this->type('password', 'test');
        $this->click("remember");
        $this->click("přihlásit");
        $this->waitForPageToLoad("30000");
    }

  function testLogin()
  {
    $this->open("wadmin/index.php/login");
    $this->type("username", "sibek");
    $this->type('password', 'test');
    $this->click("remember");
    $this->click("přihlásit");
    $this->waitForPageToLoad("30000");
    try {
        $this->assertTrue($this->isTextPresent("přihlášen: sibek"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
  }
}
?>