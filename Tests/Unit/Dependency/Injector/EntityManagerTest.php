<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Dependency\Injector;

use Doctrine\ORM\EntityManagerInterface;
use Algisimu\IntentionBundle\Dependency\Injector\EntityManager;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;

/**
 * Class EntityManagerTest
 */
class EntityManagerTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Tests if entity manager injector injects Doctrine's EntityManager into intentions.
     */
    public function testInject()
    {
        $entityManager = $this->createEntityManagerMock();

        $intention = $this->createIntentionMock('DbAwareIntentionInterface', ['setEntityManager']);

        $intention
            ->expects($this->once())
            ->method('setEntityManager')
            ->with($entityManager)
        ;

        $injector = new EntityManager($entityManager);
        $injector->inject($intention);
    }

    /**
     * Test if validator injector supports the correct injection interface.
     */
    public function testSupports()
    {
        $entityManager = $this->createEntityManagerMock();

        $injector = new EntityManager($entityManager);

        $intention = $this->createIntentionMock('DbAwareIntentionInterface');
        $this->assertTrue($injector->supports($intention));

        $intention = $this->createIntentionMock('PagingAwareIntentionInterface');
        $this->assertFalse($injector->supports($intention));

        $intention = $this->createIntentionMock('IntentionInterface');
        $this->assertFalse($injector->supports($intention));
    }

    /**
     * Creates an entity manager mock.
     *
     * @return EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createEntityManagerMock()
    {
        $entityManager = $this->getMockForAbstractClass(
            '\Doctrine\ORM\EntityManager',
            [],
            '',
            false
        );

        return $entityManager;
    }
}
