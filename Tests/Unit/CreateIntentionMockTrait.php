<?php

namespace Algisimu\IntentionBundle\Tests\Unit;

use Algisimu\IntentionBundle\Intention\IntentionInterface;

/**
 * Trait to create IntentionInterface mock.
 */
trait CreateIntentionMockTrait
{
    /**
     * @param string $interface
     * @param array  $methods
     *
     * @return IntentionInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createIntentionMock($interface = 'IntentionInterface', array $methods = [])
    {
        $intention = $this->getMockForAbstractClass(
            '\Algisimu\IntentionBundle\Intention\\' . $interface,
            $methods
        );

        return $intention;
    }
}
