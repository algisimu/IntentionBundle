<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Intention;

use Algisimu\IntentionBundle\Intention\DbAwareIntentionInterface;
use Algisimu\IntentionBundle\Intention\DbTransactionIntention;
use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Service\ExecutionManager;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DbTransactionIntentionTest
 */
class DbTransactionIntentionTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Tests if calling DbTransactionIntention::execute() will perform a transaction if no error occurs.
     */
    public function testExecuteWithCommit()
    {
        $successful = true;

        /** @var DbAwareIntentionInterface $intention */
        $intention = $this->createIntentionMock('DbAwareIntentionInterface');

        // Create managers with test assertions
        $entityManager    = $this->createEntityManagerMock($successful);
        $executionManager = $this->createExecutionManager($intention, $successful);

        $dbTransaction = new DbTransactionIntention($intention);

        $dbTransaction->setEntityManager($entityManager);
        $dbTransaction->setExecutionManager($executionManager);
        $dbTransaction->execute();
    }

    /**
     * Tests if calling DbTransactionIntention::execute() will rollback a transaction on error.
     */
    public function testExecuteWithRollback()
    {
        $this->setExpectedException('\Exception');

        $successful = false;

        /** @var DbAwareIntentionInterface $intention */
        $intention = $this->createIntentionMock('DbAwareIntention');

        // Create managers with test assertions
        $entityManager    = $this->createEntityManagerMock($successful);
        $executionManager = $this->createExecutionManager($intention, $successful);

        $dbTransaction = new DbTransactionIntention($intention);

        $dbTransaction->setEntityManager($entityManager);
        $dbTransaction->setExecutionManager($executionManager);
        $dbTransaction->execute();
    }

    /**
     * @param boolean $successful
     *
     * @return EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createEntityManagerMock($successful)
    {
        $entityManager = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            ['flush', 'getConnection'],
            [],
            '',
            false
        );

        if ($successful) {
            $entityManager->expects($this->once())->method('flush');
        }

        $connection = $this->createConnectionMock($successful);

        $entityManager
            ->expects($this->once())
            ->method('getConnection')
            ->willReturn($connection)
        ;

        return $entityManager;
    }

    /**
     * @param boolean $successful
     *
     * @return Connection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createConnectionMock($successful)
    {
        $connection = $this->getMock(
            'Doctrine\DBAL\Connection',
            ['beginTransaction', 'commit', 'rollback'],
            [],
            '',
            false
        );

        $connection->expects($this->once())->method('beginTransaction');

        if ($successful) {
            $connection->expects($this->once())->method('commit');
        } else {
            $connection->expects($this->once())->method('rollback');
        }

        return $connection;
    }

    /**
     * @param IntentionInterface $intention
     * @param boolean            $successful
     *
     * @return ExecutionManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createExecutionManager(IntentionInterface $intention, $successful)
    {
        $executionManager = $this->getMock(
            '\Algisimu\IntentionBundle\Service\ExecutionManager',
            ['execute'],
            [],
            '',
            false
        );

        if ($successful) {
            $executionManager->expects($this->once())->method('execute')->with($intention);
        } else {
            $executionManager
                ->expects($this->once())
                ->method('execute')
                ->with($intention)
                ->will($this->throwException(new \Exception()));
        }

        return $executionManager;
    }
}
