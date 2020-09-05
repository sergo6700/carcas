<?php

namespace Api\Exceptions;

use Api\Core\Exceptions\AbstractHttpException;
use Illuminate\Http\Response;

/**
 * Class NotFoundException
 * @package Api\Core\Exceptions
 */
class NotFoundException extends AbstractHttpException
{
    /**
     * NotFoundException constructor.
     * @param string $message
     */
    public function __construct(string $message = 'Not Found')
    {
        parent::__construct(new Response('Not Found', 404, []));
    }
}
