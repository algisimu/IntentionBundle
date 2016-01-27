<?php

namespace Algisimu\IntentionBundle\Intention;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Interface for intentions which are supposed to manage some entities and thus needs options resolver to check if
 * all required fields are set or optional ones are set correctly and those fields are valid.
  */
interface ParametersIntentionInterface extends IntentionInterface
{
    /**
     * Configure options resolver.
     *
     * @param OptionsResolver $optionsResolver
     */
    public function configureOptionsResolver(OptionsResolver $optionsResolver);

    /**
     * Resolve intention parameters.
     *
     * @param OptionsResolver $optionsResolver
     */
    public function resolveParameters(OptionsResolver $optionsResolver);

    /**
     * Sets an instance of Symfony\Component\Validator\Validator\ValidatorInterface for intention validation.
     *
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator);

    /**
     * Validates intention.
     *
     * @return ConstraintViolationListInterface A list of constraint violations. If the list is empty,
     *                                          validation succeeded
     */
    public function validate();

    /**
     * Indicates if intention can be auto-validated or not.
     *
     * @return boolean If true - intention will be auto-validated by intention execution manager,
     *                 if false - intention has to take care of validation by itself.
     */
    public function isAutoValidatable();

    /**
     * Executes the intention - builds parameters, validates them and returns itself if all was successful.
     *
     * @return ParametersIntentionInterface
     */
    public function execute();
}
