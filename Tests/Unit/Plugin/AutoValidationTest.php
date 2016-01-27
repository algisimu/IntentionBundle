<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Plugin;

use Algisimu\IntentionBundle\Plugin\AutoValidation;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AutoValidationTest
 */
class AutoValidationTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Tests if not supported intention is not auto-validated.
     */
    public function testApplyForNotSupportedIntention()
    {
        $intention = $this->createIntentionMock('IntentionInterface', ['validate']);

        $intention->expects($this->never())->method('validate');

        $plugin = new AutoValidation();
        $plugin->apply($intention);
    }

    /**
     * Tests if supported intention with autovalidation set to off is not auto-validated.
     */
    public function testApplyForSupportedIntentionWithNoAutovalidation()
    {
        $intention = $this->createIntentionMock('ParametersIntentionInterface', ['validate', 'isAutoValidatable']);

        $intention->expects($this->once())->method('isAutoValidatable')->willReturn(false);
        $intention->expects($this->never())->method('validate');

        $plugin = new AutoValidation();
        $plugin->apply($intention);
    }

    /**
     * Tests if supported intention with auto-validation set to on is auto-validated.
     */
    public function testApplyForSupportedIntentionWithAutovalidationAndNoErrors()
    {
        $intention = $this->createIntentionMock('ParametersIntentionInterface', ['validate', 'isAutoValidatable']);

        $errors = $this->createConstraintViolationListInterfaceMock(0);
        $intention->expects($this->once())->method('isAutoValidatable')->willReturn(true);
        $intention->expects($this->once())->method('validate')->willReturn($errors);

        $plugin = new AutoValidation();
        $plugin->apply($intention);
    }

    /**
     * Tests if supported intention with auto-validation set to on is auto-validated, has errors and throws exception.
     */
    public function testApplyForSupportedIntentionWithAutovalidationAndWithErrors()
    {
        $this->setExpectedException('Algisimu\IntentionBundle\Exception\InvalidArgumentException');

        $intention = $this->createIntentionMock('ParametersIntentionInterface', ['validate', 'isAutoValidatable']);

        $errors = $this->createConstraintViolationListInterfaceMock(1);
        $intention->expects($this->once())->method('isAutoValidatable')->willReturn(true);
        $intention->expects($this->once())->method('validate')->willReturn($errors);

        $plugin = new AutoValidation();
        $plugin->apply($intention);
    }

    /**
     * @param integer $errorCount
     *
     * @return ConstraintViolationListInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createConstraintViolationListInterfaceMock($errorCount)
    {
        $errors = $this->getMock(
            'Symfony\Component\Validator\ConstraintViolationList',
            ['count', '__toString'],
            [],
            '',
            false
        );

        $errors->expects($this->once())->method('count')->willReturn($errorCount);

        if ($errorCount > 0) {
            $errors->expects($this->once())->method('__toString')->willReturn('Validation error');
        }

        return $errors;
    }
}
