<?php

namespace Api\Exceptions;

use Api\Core\Exceptions\AbstractHttpException;
use Illuminate\Http\Response;

/**
 * Class NotFoundException
 * @package Api\Core\Exceptions
 */
class BadRequestException extends AbstractHttpException
{
    /**
     * BadRequestException constructor.
     * @param string $message
     */
    public function __construct($message = 'Bad Request')
    {
        parent::__construct(new Response($message, 400, []));
    }
}
