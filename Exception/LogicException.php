<?php

namespace Algisimu\IntentionBundle\Exception;

use Algisimu\IntentionBundle\Plugin\Collection;

/**
 * Class LogicException
 */
class LogicException extends \LogicException implements IntentionExceptionInterface
{
    /**
     * Creates an exception for invalid plugin priority values.
     *
     * @param mixed $value
     *
     * @return LogicException
     */
    public static function createPluginPriorityValueException($value)
    {
        return new self(
            sprintf(
                'Plugin priority must be an integer between %d and %d, (%s) %s given.',
                Collection::PRIORITY_MIN,
                Collection::PRIORITY_MAX,
                gettype($value),
                $value
            )
        );
    }
}
