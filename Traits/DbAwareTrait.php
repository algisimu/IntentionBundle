<?php

namespace Algisimu\IntentionBundle\Traits;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Trait is supposed to be used for intention classes implementing DbAwareIntentionInterface - adds $entityManager
 * property and a setter for it.
 */
trait DbAwareTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @inheritdoc
     *
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
