<?php

namespace Algisimu\IntentionBundle\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait is supposed to be used for intention classes implementing PagingAwareIntentionInterface - adds $limit and
 * $offset properties and setters/getter for them.
 */
trait PagingAwareTrait
{
    /**
     * Number of items to include in the list.
     *
     * @var integer
     *
     * @Assert\Type(type="integer")
     * @Assert\Range(min=1, max=9999)
     */
    protected $limit;

    /**
     * Offset for the items in the list.
     *
     * @var integer
     *
     * @Assert\Type(type="integer")
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $offset;

    /**
     * Returns the limit.
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Sets the limit.
     *
     * @param integer $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int) $limit;
    }

    /**
     * Returns the offset.
     *
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Sets the offset.
     *
     * @param integer $offset
     */
    public function setOffset($offset)
    {
        $this->offset = (int) $offset;
    }
}
