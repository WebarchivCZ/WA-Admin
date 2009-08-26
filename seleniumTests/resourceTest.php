<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * Description of resourceTest
 *
 * @author adam
 */
class resourceTest extends PHPUnit_Extensions_SeleniumTestCase
{

    function setUp()
    {
        $this->setBrowser("*chrome");
        $this->setBrowserUrl("http://localhost/");
    }

    function testViewResource ()
    { 
        $this->open("/wadmin/tables/correspondence");
        $this->click("link=Zdroje");
        $this->waitForPageToLoad("30000");
        $this->click("link=zdroj1");
        $this->waitForPageToLoad("30000");
        try
        {
            $this->assertEquals("WA Admin - Zdroje", $this->getTitle());
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try
        {
            $this->assertTrue($this->isTextPresent("Kurátor"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        try
        {
            $this->assertFalse($this->isTextPresent("id:"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {

            array_push($this->verificationErrors, $e->toString());
        }

    }

    function testViewTitle()
    {
        $this->open("/wadmin/index.php/tables/resources/view/1");
        try
        {
            $this->assertEquals("WA Admin - Zobrazení zdroje", $this->getTitle());
        } catch (PHPUnit_Framework_AssertionFailedError $e){


            array_push($this->verificationErrors, $e->toString());
        }

    }
}
?>