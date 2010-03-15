<?php
/**
 *  test case.
 */
class Contract_ModelTest extends PHPUnit_Framework_TestCase
{


    private $contract;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp ();

        $contract = new Contract_Model();
        $this->contract = $contract;
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        unset ($this->contract);

        parent::tearDown ();
    }

    public function testIsInserted() {
        $contract = new Contract_Model(1);
        $result = Contract_Model::is_already_inserted($contract->year, $contract->contract_no);
        $this->assertTrue($result);
        $year = 1980;
        $contract_no = 10000;
        $result = Contract_Model::is_already_inserted($year, $contract_no);
        $this->assertFalse($result);
    }
}

