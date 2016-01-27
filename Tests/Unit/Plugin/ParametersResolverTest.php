<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Plugin;

use Algisimu\IntentionBundle\Plugin\ParametersResolver;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

/**
 * Class ParametersResolverTest
 */
class ParametersResolverTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Tests if parameters for not supported intention is not resolved.
     */
    public function testApplyForNotSupportedIntention()
    {
        $intention = $this->createIntentionMock(
            'IntentionInterface',
            ['configureOptionsResolver', 'resolveParameters']
        );

        $intention->expects($this->never())->method('configureOptionsResolver');
        $intention->expects($this->never())->method('resolveParameters');

        $plugin = new ParametersResolver();
        $plugin->apply($intention);
    }

    /**
     * Tests if parameters for supported intention is resolved.
     */
    public function testApplyForSupportedIntention()
    {
        $intention = $this->createIntentionMock(
            'ParametersIntentionInterface',
            ['configureOptionsResolver', 'resolveParameters']
        );

        $intention->expects($this->once())->method('configureOptionsResolver');
        $intention->expects($this->once())->method('resolveParameters');

        $plugin = new ParametersResolver();
        $plugin->apply($intention);
    }

    /**
     * Tests if parameters for supported intention is resolved and exception throw for bad parameters.
     */
    public function testApplyForSupportedIntentionWithBadParametersThrowsException()
    {
        $this->setExpectedException('Algisimu\IntentionBundle\Exception\InvalidArgumentException');

        $intention = $this->createIntentionMock(
            'ParametersIntentionInterface',
            ['configureOptionsResolver', 'resolveParameters']
        );

        $intention->expects($this->once())->method('configureOptionsResolver');
        $intention
            ->expects($this->once())
            ->method('resolveParameters')
            ->willThrowException(new InvalidArgumentException());

        $plugin = new ParametersResolver();
        $plugin->apply($intention);
    }
}
