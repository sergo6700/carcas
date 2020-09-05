<?php

namespace Api\Exceptions;

use Api\Core\Exceptions\AbstractHttpException;
use Illuminate\Http\Response;

/**
 * Class AccessDeniedException
 * @package Api\Core\Exceptions
 */
class AccessDeniedException extends AbstractHttpException
{
    /**
     * AccessDeniedException constructor.
     * @param string $message
     */
    public function __construct($message = '')
    {
        parent::__construct(new Response($message, 403, []));
    }
}