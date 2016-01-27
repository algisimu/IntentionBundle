<?php

namespace Algisimu\IntentionBundle\Intention;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface for intentions which are supposed to interact with database.
 */
interface DbAwareIntentionInterface extends IntentionInterface
{
    /**
     * Sets an instance of Doctrine\ORM\EntityManagerInterface for database interactions.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager);
}
