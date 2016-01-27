<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Service;

use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Intention\ParametersIntentionInterface;
use Algisimu\IntentionBundle\Service\DependenciesManager;
use Algisimu\IntentionBundle\Service\ExecutionManager;
use Algisimu\IntentionBundle\Service\PluginsManager;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;

/**
 * Class ExecutionManagerTest
 */
class ExecutionManagerTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Test if execution manager injects itself to IntentionInterface and then executes the intention.
     */
    public function testBuildParameters()
    {
        /** @var ParametersIntentionInterface|\PHPUnit_Framework_MockObject_MockObject $intention */
        $intention = $this->createIntentionMock('ParametersIntentionInterface', ['execute', 'setExecutionManager']);

        $dependenciesManager = $this->createDependenciesManagerMock($intention);
        $pluginsManager      = $this->createPluginsManagerMock($intention);

        $manager = new ExecutioNmanager($dependenciesManager, $pluginsManager);

        $intention->expects($this->once())->method('execute');
        $intention->expects($this->never())->method('setExecutionManager')->with($manager);

        $manager->buildParameters($intention);
    }

    /**
     * Test if execution manager injects itself to IntentionInterface and then executes the intention.
     */
    public function testExecute()
    {
        $intention = $this->createIntentionMock('IntentionInterface', ['execute', 'setExecutionManager']);

        $dependenciesManager = $this->createDependenciesManagerMock($intention);
        $pluginsManager      = $this->createPluginsManagerMock($intention);

        $manager = new ExecutioNmanager($dependenciesManager, $pluginsManager);

        $intention->expects($this->once())->method('execute');
        $intention->expects($this->once())->method('setExecutionManager')->with($manager);

        $manager->execute($intention);
    }

    /**
     * @param IntentionInterface $intention
     *
     * @return DependenciesManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createDependenciesManagerMock(IntentionInterface $intention)
    {
        $manager = $this->getMock(
            'Algisimu\IntentionBundle\Service\DependenciesManager',
            ['inject'],
            [],
            '',
            false
        );

        $manager->expects($this->once())->method('inject')->with($intention);

        return $manager;
    }

    /**
     * @param IntentionInterface $intention
     *
     * @return PluginsManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPluginsManagerMock(IntentionInterface $intention)
    {
        $manager = $this->getMock(
            'Algisimu\IntentionBundle\Service\PluginsManager',
            ['apply'],
            [],
            '',
            false
        );

        $manager->expects($this->once())->method('apply')->with($intention);

        return $manager;
    }
}
