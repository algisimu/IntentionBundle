<?php

namespace Algisimu\IntentionBundle\Dependency\Injector;

use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Intention\PagingAwareIntentionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Injector class to inject an paging parameters from the request to intentions.
 */
class Paging extends AbstractInjector
{
    /**
     * @inheritdoc
     *
     * @var string
     */
    protected $supportedIntention = 'Algisimu\IntentionBundle\Intention\PagingAwareIntentionInterface';

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Default value for number of items in the list.
     *
     * @var integer
     */
    protected $defaultLimit;

    /**
     * Default value for offset items in the list.
     *
     * @var integer
     */
    protected $defaultOffset;

    /**
     * Paging constructor.
     *
     * @param RequestStack $requestStack
     * @param integer      $defaultLimit
     * @param integer      $defaultOffset
     */
    public function __construct(RequestStack $requestStack, $defaultLimit = 0, $defaultOffset = 0)
    {
        $this->requestStack  = $requestStack;
        $this->defaultLimit  = $defaultLimit;
        $this->defaultOffset = $defaultOffset;
    }

    /**
     * Injects paging parameters into given $intention.
     *
     * @param PagingAwareIntentionInterface|IntentionInterface $intention
     */
    public function inject(IntentionInterface $intention)
    {
        $request = $this->requestStack->getCurrentRequest();

        $intention->setLimit(
            $request->query->get('limit', $this->defaultLimit)
        );

        $intention->setOffset(
            $request->query->get('offset', $this->defaultOffset)
        );
    }
}
