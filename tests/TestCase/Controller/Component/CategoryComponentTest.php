<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\CategoryComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\CategoryComponent Test Case
 */
class CategoryComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\CategoryComponent
     */
    public $Category;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Category = new CategoryComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Category);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
