<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Http\Controllers\Traits\CrudTrait;
use Api\Http\Controllers\Traits\ListableTrait;
use Api\Services\RoomTypesService;

/**
 * Class RoomTypesController
 * @package Api\Http\Controllers
 */
class RoomTypesController extends BaseApiController
{
    use CrudTrait, ListableTrait;

    /**
     * RoomTypesController constructor.
     * @param Response $response
     * @param RoomTypesService $service
     */
    public function __construct(
        Response $response,
        RoomTypesService $service
    )
    {
        parent::__construct($response, $service);
    }
}
