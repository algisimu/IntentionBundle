<?php

namespace Algisimu\IntentionBundle\Controller\Traits;

use Algisimu\IntentionBundle\Intention\IntentionInterface;
use Algisimu\IntentionBundle\Intention\ParametersIntentionInterface;
use Algisimu\IntentionBundle\Service\ExecutionManager;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait IntentionControllerTrait
{
    /**
     * Get intention manager from container.
     *
     * @return ExecutionManager
     */
    protected function getIntentionManager()
    {
        return $this->get('intention.execution_manager');
    }

    /**
     * Builds parameters.
     *
     * @param ParametersIntentionInterface $intention
     *
     * @return ParametersIntentionInterface
     */
    protected function buildParameters(ParametersIntentionInterface $intention )
    {
        try {
            return $this->getIntentionManager()->execute($intention);
        } catch (\InvalidArgumentException $e) {
            $this->handleInvalidArgumentException($e);
        }
    }

    /**
     * Executes intention.
     *
     * @param IntentionInterface $intention
     *
     * @return mixed
     */
    protected function executeIntention(IntentionInterface $intention )
    {
        return $this->getIntentionManager()->execute($intention);
    }

    /**
     * Handles cases where some bad parameters were passed to the intention.
     *
     * @param \InvalidArgumentException $exception
     *
     * @throws BadRequestHttpException
     */
    protected function handleInvalidArgumentException(\InvalidArgumentException $exception)
    {
        throw new BadRequestHttpException($exception->getMessage());
    }
}
