<?php

namespace Algisimu\IntentionBundle\Intention;

/**
 * Interface for intentions which are supposed to return list with a possibility for pagination.
 */
interface PagingAwareIntentionInterface extends IntentionInterface
{
    /**
     * Get the maximum number of items list should contain.
     *
     * @return integer
     */
    public function getLimit();

    /**
     * Set the maximum number of items list should contain.
     *
     * @param integer $limit
     */
    public function setLimit($limit);

    /**
     * Get the offset for list items.
     *
     * @return integer
     */
    public function getOffset();

    /**
     * Set the offset for list items.
     *
     * @param integer $offset
     */
    public function setOffset($offset);
}
