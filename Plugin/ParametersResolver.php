<?php

namespace Algisimu\IntentionBundle\Plugin;

use Algisimu\IntentionBundle\Exception\InvalidArgumentException;
use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Intention\ParametersIntentionInterface;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Plugin to automatically resolve intention parameters via OptionsResolver.
 */
class ParametersResolver implements PluginInterface
{
    /**
     * Automatically resolves $intention parameters if intention supports it.
     *
     * @param IntentionInterface $intention
     */
    public function apply(IntentionInterface $intention)
    {
        if ($this->supports($intention)) {
            /** @var ParametersIntentionInterface $intention */
            $this->resolveParameters($intention);
        }
    }

    /**
     * Checks if given $intention supports resolvable parameters.
     *
     * @param IntentionInterface $intention
     *
     * @return boolean
     */
    protected function supports(IntentionInterface $intention)
    {
        return $intention instanceof ParametersIntentionInterface;
    }

    /**
     * Creates an instance of OptionsResolver which is then configured and used by given $intention.
     *
     * @param ParametersIntentionInterface $intention
     * @throws InvalidArgumentException
     */
    protected function resolveParameters(ParametersIntentionInterface $intention)
    {
        $optionsResolver = new OptionsResolver();

        $intention->configureOptionsResolver($optionsResolver);

        try {
            $intention->resolveParameters($optionsResolver);
        } catch (ExceptionInterface $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
