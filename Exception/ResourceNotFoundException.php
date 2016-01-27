<?php

namespace Algisimu\IntentionBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ResourceNotFoundException
 */
class ResourceNotFoundException extends NotFoundHttpException implements IntentionExceptionInterface
{
}
