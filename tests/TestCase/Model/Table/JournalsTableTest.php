<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JournalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JournalsTable Test Case
 */
class JournalsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\JournalsTable
     */
    public $Journals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.journals',
        'app.debits',
        'app.credits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Journals') ? [] : ['className' => 'App\Model\Table\JournalsTable'];
        $this->Journals = TableRegistry::get('Journals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Journals);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
