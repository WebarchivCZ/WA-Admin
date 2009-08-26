<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://change-this-to-the-site-you-are-testing/");
  }

  function testMyTestCase()
  {
    basicFunctionalityTest::login();
    $this->open("/wadmin/index.php/tables/ratings/view/12");
    try {
        $this->assertTrue($this->isTextPresent("-1"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
  }
}
?>