<?php

namespace Algisimu\IntentionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DependenciesCompilerPass
 */
class DependenciesCompilerPass implements CompilerPassInterface
{
    /**
     * Adds injectors into an InjectorChain
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('intention.dependencies_manager')) {
            return;
        }

        $definition = $container->getDefinition('intention.dependencies_manager');

        $taggedServices = $container->findTaggedServiceIds('intention.dependency_injector');

        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addDependencyInjector', [new Reference($id)]);
        }
    }
}
