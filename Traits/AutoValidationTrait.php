<?php

namespace Algisimu\IntentionBundle\Traits;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Use for intention classes implementing ParametersIntentionInterface. It implements validation methods for that
 * interface
 */
trait AutoValidationTrait
{
    /**
     * Validator.
     *
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @inheritdoc
     *
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     *
     * @return ConstraintViolationListInterface A list of constraint violations. Empty list means that
     *                                          validation succeeded
     */
    public function validate()
    {
        return $this->validator->validate($this);
    }

    /**
     * @inheritdoc
     *
     * @return boolean If true - intention will be auto-validated by intention execution manager via plugin,
     *                 if false - intention has to take care of validation by itself.
     */
    public function isAutoValidatable()
    {
        return true;
    }
}
