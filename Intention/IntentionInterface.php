<?php

namespace Algisimu\IntentionBundle\Intention;

use Algisimu\IntentionBundle\Service\ExecutionManager;

/**
 * Interface for intentions.
 */
interface IntentionInterface
{
    /**
     * Sets execution manager.
     *
     * @param ExecutionManager $executionManager
     */
    public function setExecutionManager(ExecutionManager $executionManager);

    /**
     * Executes the intention.
     *
     * @return mixed
     */
    public function execute();
}
