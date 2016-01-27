<?php

namespace Algisimu\IntentionBundle\Intention;

use Algisimu\IntentionBundle\Service\ExecutionManager;

/**
 * Abstract intention class.
 */
abstract class AbstractIntention implements IntentionInterface
{
    /**
     * @var ExecutionManager
     */
    protected $executionManager;

    /**
     * @inheritdoc
     *
     * @param ExecutionManager $executionManager
     */
    public function setExecutionManager(ExecutionManager $executionManager)
    {
        $this->executionManager = $executionManager;
    }
}
