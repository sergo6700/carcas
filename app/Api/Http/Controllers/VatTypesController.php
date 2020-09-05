<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Http\Controllers\Traits\CrudTrait;
use Api\Http\Controllers\Traits\ListableTrait;
use Api\Services\CompaniesService;
use Api\Services\VatTypesService;
use PragmaRX\Countries\Package\Services\Cache\Service;

/**
 * Class CompaniesController
 * @package Api\Http\Controllers
 */
class VatTypesController extends BaseApiController
{
    use CrudTrait, ListableTrait;

    /**
     * CompaniesController constructor.
     * @param VatTypesService $service
     * @param Response $response
     */
    public function __construct(
        VatTypesService $service,
        Response $response
    )
    {
        parent::__construct($response,$service);
    }

}
