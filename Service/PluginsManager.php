<?php

namespace Algisimu\IntentionBundle\Service;

use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Plugin;
use Algisimu\IntentionBundle\Plugin\PluginInterface;

/**
 * Manages plugins for intentions.
 */
class PluginsManager
{
    /**
     * @var Plugin\Collection
     */
    protected $pluginsCollection;


    /**
     * PluginsManager constructor.
     *
     * @param Plugin\Collection $pluginsCollection
     */
    public function __construct(Plugin\Collection $pluginsCollection)
    {
        $this->pluginsCollection = $pluginsCollection;
    }

    /**
     * Applies all plugins to given $intention based on their priority.
     *
     * @param IntentionInterface $intention
     */
    public function apply(IntentionInterface $intention)
    {
        $plugins = $this->pluginsCollection->getPlugins();

        foreach ($plugins as $priorityPlugins) {
            foreach ($priorityPlugins as $plugin) {
                /** @var PluginInterface $plugin */
                $plugin->apply($intention);
            }
        }
    }
}
