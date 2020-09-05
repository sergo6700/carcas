<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Http\Controllers\Traits\CrudTrait;
use Api\Services\ReservationsService;

/**
 * Class ReservationsController
 * @package Api\Http\Controllers
 */
class ReservationsController extends BaseApiController
{
    use CrudTrait;

    /**
     * ReservationsController constructor.
     * @param Response $response
     * @param ReservationsService $service
     */
    public function __construct(
        Response $response,
        ReservationsService $service
    )
    {
        parent::__construct($response, $service);
    }

}
