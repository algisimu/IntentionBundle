<?php

namespace Algisimu\IntentionBundle\Dependency\Injector;

use Algisimu\IntentionBundle\Intention\IntentionInterface;

/**
 * Abstract dependency injector class.
 */
abstract class AbstractInjector implements InjectorInterface
{
    /**
     * Full name of the intention interface supported by this dependency injector.
     *
     * @var string
     */
    protected $supportedIntention;

    /**
     * @inheritdoc
     *
     * @param IntentionInterface $intention
     *
     * @return boolean
     */
    public function supports(IntentionInterface $intention)
    {
        return is_a($intention, $this->supportedIntention);
    }
}
