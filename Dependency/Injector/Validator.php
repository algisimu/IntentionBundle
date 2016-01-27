<?php

namespace Algisimu\IntentionBundle\Dependency\Injector;

use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Intention\ParametersIntentionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Injector class to inject an instance of Symfony\Component\Validator\Validator\ValidatorInterface
 * to intentions for intention validation.
 */
class Validator extends AbstractInjector
{
    /**
     * @inheritdoc
     *
     * @var string
     */
    protected $supportedIntention = 'Algisimu\IntentionBundle\Intention\ParametersIntentionInterface';

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Validator constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Injects an instance of Symfony\Component\Validator\Validator\ValidatorInterface into given $intention.
     *
     * @param ParametersIntentionInterface|IntentionInterface $intention
     */
    public function inject(IntentionInterface $intention)
    {
        $intention->setValidator($this->validator);
    }
}
