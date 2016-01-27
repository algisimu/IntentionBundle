<?php

namespace Algisimu\IntentionBundle\Dependency\Injector;

use Algisimu\IntentionBundle\Intention\IntentionInterface;

/**
 * Interface for dependency injectors.
 */
interface InjectorInterface
{
    /**
     * Checks if given $intention is supported by dependency injector.
     *
     * @param IntentionInterface $intention
     *
     * @return boolean
     */
    public function supports(IntentionInterface $intention);

    /**
     * Injects a dependency into given $intention.
     *
     * @param IntentionInterface $intention
     */
    public function inject(IntentionInterface $intention);
}
