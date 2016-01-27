<?php

namespace Algisimu\IntentionBundle\Service;

use Algisimu\IntentionBundle\Dependency\Injector\InjectorInterface;
use Algisimu\IntentionBundle\Intention\IntentionInterface;

/**
 * Chains injectors of dependencies for intentions.
 */
class DependenciesManager
{
    /**
     * List of injectors which will be applied to the intention.
     *
     * @var InjectorInterface[]|array
     */
    protected $injectors;

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->injectors = [];
    }

    /**
     * @inheritdoc
     *
     * @param IntentionInterface $intention
     */
    public function inject(IntentionInterface $intention)
    {
        foreach ($this->injectors as $injector) {
            if (!$injector->supports($intention)) {
                continue;
            }

            $injector->inject($intention);
        }
    }

    /**
     * Adds $injector to the injectors list.
     *
     * @param InjectorInterface $injector
     */
    public function addDependencyInjector(InjectorInterface $injector)
    {
        $this->injectors[] = $injector;
    }
}
