<?php
/**
 * poptin plugin for Craft CMS 3.x
 *
 * Create advanced website popups and forms, and improve your website's conversion rate within a few minutes.
 *
 * @link      poptin.com
 * @copyright Copyright (c) 2020 Poptin
 */

namespace poptin\poptintests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use poptin\poptin\Poptin;

/**
 * ExampleUnitTest
 *
 *
 * @author    Poptin
 * @package   Poptin
 * @since     1.0.0
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            Poptin::class,
            Poptin::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
