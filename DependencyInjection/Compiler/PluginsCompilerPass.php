<?php

namespace Algisimu\IntentionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PluginsCompilerPass
 */
class PluginsCompilerPass implements CompilerPassInterface
{
    /**
     * Adds plugin into ExecutionManager
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('intention.plugin.collection')) {
            return;
        }

        $definition = $container->getDefinition('intention.plugin.collection');

        $taggedServices = $container->findTaggedServiceIds('intention.plugin');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $priorityValue = isset($attributes['priority']) ? $attributes['priority'] : 0;
                $definition->addMethodCall(
                    'addPlugin',
                    [
                        new Reference($id),
                        $priorityValue
                    ]
                );
            }
        }
    }
}
