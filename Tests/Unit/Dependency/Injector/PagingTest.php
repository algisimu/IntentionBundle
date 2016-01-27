<?php

namespace Algisimu\IntentionBundle\Tests\Unit\Dependency\Injector;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Algisimu\IntentionBundle\Dependency\Injector\Paging;
use Algisimu\IntentionBundle\Tests\Unit\CreateIntentionMockTrait;

/**
 * Class PagingTest
 */
class PagingTest extends \PHPUnit_Framework_TestCase
{
    use CreateIntentionMockTrait;

    /**
     * Data provider for self::testInject().
     *
     * @return array
     */
    public function getTestInjectData()
    {
        $out = [];

        $out[] = ['limit' => null, 'offset' => null, 'defaultLimit' => 0, 'defaultOffset' => 0];
        $out[] = ['limit' => 1,    'offset' => 2,    'defaultLimit' => 0, 'defaultOffset' => 0];
        $out[] = ['limit' => 1,    'offset' => null, 'defaultLimit' => 3, 'defaultOffset' => 4];
        $out[] = ['limit' => null, 'offset' => 2,    'defaultLimit' => 3, 'defaultOffset' => 0];

        return $out;
    }

    /**
     * Tests if paging injector injects given paging values from request into intentions.
     *
     * @param integer $limit
     * @param integer $offset
     * @param integer $defaultLimit
     * @param integer $defaultOffset
     *
     * @dataProvider getTestInjectData()
     */
    public function testInject($limit, $offset, $defaultLimit, $defaultOffset)
    {
        $query        = $this->createParameterBag($limit, $offset);
        $request      = $this->getRequestMock($query);
        $requestStack = $this->getRequestStackMock($request);

        $intention = $this->createIntentionMock('PagingAwareIntentionInterface', ['setOffset', 'setLimit']);

        if (null !== $limit) {
            $intention->expects($this->once())->method('setLimit')->with($limit);
        } else {
            $intention->expects($this->once())->method('setLimit')->with($defaultLimit);
        }

        if (null !== $offset) {
            $intention->expects($this->once())->method('setOffset')->with($offset);
        } else {
            $intention->expects($this->once())->method('setOffset')->with($defaultOffset);
        }

        $injector = new Paging($requestStack, $defaultLimit, $defaultOffset);
        $injector->inject($intention);
    }

    /**
     * Test if validator injector supports the correct injection interface.
     */
    public function testSupports()
    {
        $query        = $this->createParameterBag(0, 0);
        $request      = $this->getRequestMock($query);
        $requestStack = $this->getRequestStackMock($request, false);

        $injector = new Paging($requestStack, 0, 0);

        $intention = $this->createIntentionMock('PagingAwareIntentionInterface');
        $this->assertTrue($injector->supports($intention));

        $intention = $this->createIntentionMock('ParametersIntentionInterface');
        $this->assertFalse($injector->supports($intention));

        $intention = $this->createIntentionMock('IntentionInterface');
        $this->assertFalse($injector->supports($intention));
    }

    /**
     * Creates and returns a request stack mock.
     *
     * @param Request $request
     * @param boolean $expectsCall
     *
     * @return RequestStack|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRequestStackMock(Request $request, $expectsCall = true)
    {
        $stackMock = $this->getMock(
            'Symfony\Component\HttpFoundation\RequestStack',
            ['getCurrentRequest']
        );

        if ($expectsCall) {
            $stackMock
                ->expects($this->once())
                ->method('getCurrentRequest')
                ->willReturn($request)
            ;
        }

        return $stackMock;
    }

    /**
     * Creates a request mock.
     *
     * @param ParameterBag $query
     *
     * @return Request|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getRequestMock(ParameterBag $query)
    {
        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->getMock('Symfony\Component\HttpFoundation\Request');

        $requestMock->query = $query;

        return $requestMock;
    }

    /**
     * Creates a parameters bag.
     *
     * @param integer $limit
     * @param integer $offset
     *
     * @return ParameterBag
     */
    protected function createParameterBag($limit, $offset)
    {
        $params = [];

        if (null !== $limit) {
            $params['limit'] = $limit;
        }

        if (null !== $offset) {
            $params['offset'] = $offset;
        }

        $bag = new ParameterBag($params);

        return $bag;
    }
}
