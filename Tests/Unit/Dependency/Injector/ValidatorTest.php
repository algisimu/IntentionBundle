<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Dependency\Injector;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Algisimu\IntentionBundle\Dependency\Injector\Validator;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;

/**
 * Class ValidatorTest
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Tests if validator injector injects Symfony's Validator into intentions.
     */
    public function testInject()
    {
        $validator = $this->createValidatorMock();

        $intention = $this->createIntentionMock('ParametersIntentionInterface', ['setValidator']);

        $intention
            ->expects($this->once())
            ->method('setValidator')
            ->with($validator)
        ;

        $injector = new Validator($validator);
        $injector->inject($intention);
    }

    /**
     * Test if validator injector supports the correct injection interface.
     */
    public function testSupports()
    {
        $validator = $this->createValidatorMock();

        $injector = new Validator($validator);

        $intention = $this->createIntentionMock('ParametersIntentionInterface');
        $this->assertTrue($injector->supports($intention));

        $intention = $this->createIntentionMock('PagingAwareIntentionInterface');
        $this->assertFalse($injector->supports($intention));

        $intention = $this->createIntentionMock('IntentionInterface');
        $this->assertFalse($injector->supports($intention));
    }

    /**
     * Creates a validator mock.
     *
     * @return ValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createValidatorMock()
    {
        $validator = $this->getMockForAbstractClass(
            'Symfony\Component\Validator\Validator\ValidatorInterface',
            [],
            '',
            false
        );

        return $validator;
    }
}
