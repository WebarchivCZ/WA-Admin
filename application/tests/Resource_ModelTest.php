<?php
/**
 *  test case.
 */
class Resource_ModelTest extends PHPUnit_Framework_TestCase
{


    private $resource;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp ();

        $resource = new Resource_Model();
        $this->resource = $resource;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        unset ($this->resource);

        parent::tearDown ();
    }

    public function testCataloguedValue() {
        $this->resource->catalogued = '2009-11-19';
        // getCatalogued vraci formatovane datum
        $this->assertEquals('19.11.2009', $this->resource->catalogued);
    }

    public function testCataloguedTrue () {
        $this->resource->catalogued = TRUE;
        $today = date('d.m.Y');
        $this->assertEquals($today, $this->resource->catalogued);
    }

    public function testCataloguedOne () {
        $this->resource->catalogued = 1;
        $today = date('d.m.Y');
        $this->assertEquals($today, $this->resource->catalogued);
    }

    public function testCataloguedSetValueStay() {
        $this->resource->catalogued = '2009-11-19';
        $this->resource->catalogued = 1;
        $this->assertEquals('19.11.2009', $this->resource->catalogued);
    }
}

