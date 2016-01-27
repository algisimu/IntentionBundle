<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Plugin;

use Algisimu\IntentionBundle\Plugin\PluginInterface;
use Algisimu\IntentionBundle\Plugin\Collection;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;

/**
 * Class CollectionTest
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Data provider for self::testPluginPriority()
     *
     * @return array
     */
    public function getTestPluginPriorityData()
    {
        $out = [];

        $out[] = ['priority' => Collection::PRIORITY_MIN, 'expectsException' => false];
        $out[] = ['priority' => -1, 'expectsException' => false];
        $out[] = ['priority' => 0, 'expectsException' => false];
        $out[] = ['priority' => 0, 'expectsException' => false]; // Repeat same priority
        $out[] = ['priority' => 1, 'expectsException' => false];
        $out[] = ['priority' => 1, 'expectsException' => false]; // Repeat same priority
        $out[] = ['priority' => Collection::PRIORITY_MAX, 'expectsException' => false];
        $out[] = ['priority' => Collection::PRIORITY_MIN - 1, 'expectsException' => true];
        $out[] = ['priority' => Collection::PRIORITY_MAX + 1, 'expectsException' => true];

        return $out;
    }

    /**
     * Tests if dependencies manager behaves as expected.
     *
     * @param mixed   $priority
     * @param boolean $expectsException
     *
     * @dataProvider getTestPluginPriorityData()
     */
    public function testPluginPriority($priority, $expectsException)
    {
        if ($expectsException) {
            $this->setExpectedException('\Algisimu\IntentionBundle\Exception\LogicException');
        }

        $collection = new Collection();

        $plugin = $this->createPluginMock();

        $collection->addPlugin($plugin, $priority);
    }

    /**
     * Tests that plugins are sorted correctly then trying to get them via Collection::getPlugins().
     */
    public function testPluginPrioritySorting()
    {
        $collection = new Collection();

        $plugin = $this->createPluginMock();

        $collection->addPlugin($plugin, 0);
        $collection->addPlugin($plugin, 0);
        $collection->addPlugin($plugin, -2);
        $collection->addPlugin($plugin, -5);
        $collection->addPlugin($plugin, 5);
        $collection->addPlugin($plugin, 100);
        $collection->addPlugin($plugin, 100);

        $plugins = $collection->getPlugins();

        $this->assertEquals(array_keys($plugins), [-5, -2, 0, 5, 100]);
        $this->assertCount(1, $plugins[-5]);
        $this->assertCount(1, $plugins[-2]);
        $this->assertCount(2, $plugins[0]);
        $this->assertCount(1, $plugins[5]);
        $this->assertCount(2, $plugins[100]);
    }

    /**
     * @return PluginInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPluginMock()
    {
        $plugin = $this->getMockForAbstractClass(
            'Algisimu\IntentionBundle\Plugin\PluginInterface',
            ['apply'],
            '',
            false
        );

        return $plugin;
    }
}
