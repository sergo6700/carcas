<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Http\Controllers\Traits\CrudTrait;
use Api\Http\Requests\RateCalendar\RateCalendarGetRequest;
use Api\Http\Requests\RateCalendar\RateCreateRequest;
use Api\Services\RateCalendarService;
use Illuminate\Http\Request;

/**
 * Class RateCalendarController
 * @package Api\Http\Controllers
 */
class RateCalendarController extends BaseApiController
{
    use CrudTrait;

    /**
     * RateCalendarController constructor.
     * @param Response $response
     * @param RateCalendarService $service
     */
    public function __construct(
        Response $response,
        RateCalendarService $service
    )
    {
        parent::__construct($response, $service);
    }

    /**
     * @param RateCalendarGetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function detailed(RateCalendarGetRequest $request)
    {
        return $this->response->make($this->service->detailed($request->all()));
    }

    /**
     * @param RateCalendarGetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function compressed(RateCalendarGetRequest $request)
    {
        return $this->response->make($this->service->compressed($request->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function children($id, Request $request)
    {
        return $this->response->make($this->service->children($id, $request->all()));
    }

    /**
     * @param RateCreateRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function create(RateCreateRequest $request)
    {
        return $this->processCreation($request->all());
    }
}
