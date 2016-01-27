<?php

namespace Algisimu\IntentionBundle\Service;

use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Intention\ParametersIntentionInterface;

/**
 * Manages execution of intentions.
 */
class ExecutionManager
{
    /**
     * Dependencies manager.
     *
     * @var DependenciesManager
     */
    private $dependenciesManager;

    /**
     * Plugins manager.
     *
     * @var PluginsManager
     */
    private $pluginsManager;

    /**
     * ExecutionManager constructor.
     *
     * @param DependenciesManager $dependenciesManager
     * @param PluginsManager      $pluginsManager
     */
    public function __construct(DependenciesManager $dependenciesManager, PluginsManager $pluginsManager)
    {
        $this->dependenciesManager = $dependenciesManager;
        $this->pluginsManager      = $pluginsManager;
    }

    /**
     *
     * @param ParametersIntentionInterface $intention
     *
     * @return ParametersIntentionInterface
     */
    public function buildParameters(ParametersIntentionInterface $intention)
    {
        $this->injectDependencies($intention);
        $this->applyPlugins($intention);

        return $intention->execute();
    }

    /**
     * Executes given $intention.
     *
     * @param IntentionInterface $intention
     *
     * @return mixed
     */
    public function execute(IntentionInterface $intention)
    {
        $this->injectDependencies($intention);
        $this->applyPlugins($intention);

        $intention->setExecutionManager($this);

        return $intention->execute();
    }

    /**
     * Injects dependencies for given $intention.
     *
     * @param IntentionInterface $intention
     */
    protected function injectDependencies(IntentionInterface $intention)
    {
        $this->dependenciesManager->inject($intention);
    }

    /**
     * Applies plugins for given $intention.
     *
     * @param IntentionInterface $intention
     */
    protected function applyPlugins(IntentionInterface $intention)
    {
        $this->pluginsManager->apply($intention);
    }
}
