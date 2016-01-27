<?php

namespace Algisimu\IntentionBundle;

use Algisimu\IntentionBundle\DependencyInjection\Compiler\DependenciesCompilerPass;
use Algisimu\IntentionBundle\DependencyInjection\Compiler\PluginsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * IntentionBundle class.
 */
class IntentionBundle extends Bundle
{
    /**
     * @inheritdoc
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DependenciesCompilerPass());
        $container->addCompilerPass(new PluginsCompilerPass());
    }
}
