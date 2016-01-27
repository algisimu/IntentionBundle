<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Service;

use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Plugin\PluginInterface;
use Algisimu\IntentionBundle\Plugin\Collection;
use Algisimu\IntentionBundle\Service\PluginsManager;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;

/**
 * Class PluginsManagerTest
 */
class PluginsManagerTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Tests if dependencies manager behaves as expected.
     */
    public function testManager()
    {
        $intention = $this->createIntentionMock();

        $plugins = [
            -10 => [
                $this->createPluginMock($intention),
                $this->createPluginMock($intention),
            ],
            0 => [
                $this->createPluginMock($intention),
            ],
            100 => [
                $this->createPluginMock($intention),
                $this->createPluginMock($intention),
            ]
        ];

        $collectionMock = $this->createPluginsCollectionMock($plugins);

        $manager = new PluginsManager($collectionMock);

        $manager->apply($intention);
    }

    /**
     * @param array $plugins
     *
     * @return Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPluginsCollectionMock(array $plugins)
    {
        $collection = $this->getMock(
            'Algisimu\IntentionBundle\Plugin\Collection',
            ['getPlugins']
        );

        $collection->expects($this->once())->method('getPlugins')->willReturn($plugins);

        return $collection;
    }

    /**
     * @param IntentionInterface $intention
     *
     * @return PluginInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPluginMock(IntentionInterface $intention)
    {
        $plugin = $this->getMockForAbstractClass(
            'Algisimu\IntentionBundle\Plugin\PluginInterface',
            ['apply'],
            '',
            false
        );

        $plugin->expects($this->once())->method('apply')->with($intention);

        return $plugin;
    }
}
