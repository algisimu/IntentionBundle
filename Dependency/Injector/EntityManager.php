<?php

namespace Algisimu\IntentionBundle\Dependency\Injector;

use Algisimu\IntentionBundle\Intention\DbAwareIntentionInterface;
use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Injector class to inject an instance of Doctrine\ORM\EntityManagerInterface to intentions for database interactions.
 */
class EntityManager extends AbstractInjector
{
    /**
     * @inheritdoc
     *
     * @var string
     */
    protected $supportedIntention = 'Algisimu\IntentionBundle\Intention\DbAwareIntentionInterface';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * EntityManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Injects an instance of Doctrine\ORM\EntityManagerInterface into given $intention.
     *
     * @param DbAwareIntentionInterface|IntentionInterface $intention
     */
    public function inject(IntentionInterface $intention)
    {
        $intention->setEntityManager($this->entityManager);
    }
}
