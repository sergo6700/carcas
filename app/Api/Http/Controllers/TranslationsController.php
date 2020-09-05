<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Services\TranslationsService;
use Illuminate\Routing\Controller;

/**
 * Class TranslationsController
 * @package Api\Http\Controllers
 */
class TranslationsController extends Controller
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var TranslationsService
     */
    protected $service;

    /**
     * TranslationsController constructor.
     * @param Response $response
     * @param TranslationsService $service
     */
    public function __construct(
        Response $response,
        TranslationsService $service
    )
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return $this->response->make($this->service->get());
    }
}
