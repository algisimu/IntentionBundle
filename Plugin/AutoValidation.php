<?php

namespace Algisimu\IntentionBundle\Plugin;

use Algisimu\IntentionBundle\Exception\InvalidArgumentException;
use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Intention\ParametersIntentionInterface;

/**
 * Plugin to automatically validate supported intentions.
 */
class AutoValidation implements PluginInterface
{
    /**
     * Automatically validates given $intention if it supports auto-validation.
     *
     * @param IntentionInterface $intention
     *
     * @return mixed
     */
    public function apply(IntentionInterface $intention)
    {
        if ($this->supports($intention)) {
            /** @var ParametersIntentionInterface $intention */
            $this->validate($intention);
        }
    }

    /**
     * Checks if given $intention supports auto-validation.
     *
     * @param IntentionInterface $intention
     *
     * @return boolean
     */
    protected function supports(IntentionInterface $intention)
    {
        if (!($intention instanceof ParametersIntentionInterface)) {
            return false;
        }

        return $intention->isAutoValidatable();
    }

    /**
     * Validates given $intentions.
     *
     * @param ParametersIntentionInterface $intention
     *
     * @throws InvalidArgumentException
     */
    protected function validate(ParametersIntentionInterface $intention)
    {
        $errors = $intention->validate();

        if ($errors->count() > 0) {
            throw new InvalidArgumentException($errors);
        }
    }
}
