<?php

namespace Algisimu\IntentionBundle\Plugin;

use Algisimu\IntentionBundle\Exception\LogicException;

/**
 * Plugins collection.
 */
class Collection
{
    /**
     * Minimum allowed value for plugin priority.
     *
     * @var integer
     */
    const PRIORITY_MIN = -128;

    /**
     * Maximum allowed value for plugin priority.
     *
     * @var integer
     */
    const PRIORITY_MAX = 255;

    /**
     * Array of intention plugins grouped by their priority.
     *
     * @var PluginInterface[]|array
     */
    protected $plugins;

    /**
     * Collection constructor.
     */
    public function __construct()
    {
        $this->plugins = [];
    }

    /**
     * Adds given $plugin with given $priority to the plugins list.
     *
     * @param PluginInterface $plugin
     * @param integer         $priority
     *
     * @throws LogicException If given plugin priority value is not valid.
     */
    public function addPlugin(PluginInterface $plugin, $priority = 0)
    {
        if (!is_int($priority)
            || self::PRIORITY_MIN > $priority
            || self::PRIORITY_MAX < $priority
        ) {
            throw LogicException::createPluginPriorityValueException($priority);
        }

        $this->plugins[$priority][] = $plugin;
    }

    /**
     * Getter for self::$plugins.
     *
     * @return PluginInterface[]|array
     */
    public function getPlugins()
    {
        ksort($this->plugins);

        return $this->plugins;
    }
}
