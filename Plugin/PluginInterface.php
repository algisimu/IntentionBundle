<?php

namespace Algisimu\IntentionBundle\Plugin;

use Algisimu\IntentionBundle\Intention\IntentionInterface;

/**
 * Interface for intention plugins.
 */
interface PluginInterface
{
    /**
     * Applies plugin to given $intention.
     *
     * @param IntentionInterface $intention
     */
    public function apply(IntentionInterface $intention);
}
