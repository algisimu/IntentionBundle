<?php

namespace Algisimu\IntentionBundle\Intention;

use Algisimu\IntentionBundle\Traits\DbAwareTrait;

/**
 * Intention wrapper which is supposed to be ran in a database transaction.
 */
class DbTransactionIntention extends AbstractIntention implements DbAwareIntentionInterface
{
    use DbAwareTrait;

    /**
     * Intention which will be wrapped into a DB transaction.
     *
     * @var DbAwareIntentionInterface
     */
    protected $intention;

    /**
     * DbTransactionIntention constructor.
     *
     * @param DbAwareIntentionInterface $intention
     */
    public function __construct(DbAwareIntentionInterface $intention)
    {
        $this->intention = $intention;
    }

    /**
     * Wraps given $intention in a database transaction.
     *
     * @return mixed
     *
     * @throws \Exception Rethrows any exception caught during the execution.
     */
    public function execute()
    {
        $connection = $this->entityManager->getConnection();

        $connection->beginTransaction();

        try {
            $result = $this->executionManager->execute($this->intention);

            $this->entityManager->flush();
            $connection->commit();

            return $result;
        } catch (\Exception $e) {
            $connection->rollBack();

            throw $e;
        }
    }
}
