<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Service;

use Algisimu\IntentionBundle\Dependency\Injector\InjectorInterface;
use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Service\DependenciesManager;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;

/**
 * Class DependenciesManagerTest
 */
class DependenciesManagerTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Tests if dependencies manager behaves as expected.
     */
    public function testManager()
    {
        $manager = new DependenciesManager();

        $intention = $this->createIntentionMock();

        $injectors = [
            $this->createInjectorMock(true, $intention),
            $this->createInjectorMock(true, $intention),
            $this->createInjectorMock(false, $intention),
        ];

        foreach ($injectors as $injector) {
            $manager->addDependencyInjector($injector);
        }

        $manager->inject($intention);
    }

    /**
     * @param boolean            $supports
     * @param IntentionInterface $intention
     *
     * @return InjectorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createInjectorMock($supports, IntentionInterface $intention)
    {
        $injector = $this->getMockForAbstractClass(
            'Algisimu\IntentionBundle\Dependency\Injector\InjectorInterface',
            ['supports', 'inject'],
            '',
            false
        );

        $injector->expects($this->once())->method('supports')->with($intention)->willReturn($supports);

        if ($supports) {
            $injector->expects($this->once())->method('inject')->with($intention);
        } else {
            $injector->expects($this->never())->method('inject');
        }

        return $injector;
    }
}
