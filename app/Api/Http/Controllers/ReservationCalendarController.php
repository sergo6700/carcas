<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Http\Controllers\Traits\CrudTrait;
use Api\Http\Requests\ReservationCalendar\ReservationCalendarGetRequest;
use Api\Services\ReservationCalendarService;

/**
 * Class ReservationCalendarController
 * @package Api\Http\Controllers
 */
class ReservationCalendarController extends BaseApiController
{
    use CrudTrait;

    /**
     * ReservationCalendarController constructor.
     * @param Response $response
     * @param ReservationCalendarService $service
     */
    public function __construct(
        Response $response,
        ReservationCalendarService $service
    )
    {
        parent::__construct($response, $service);
    }

    /**
     * @param ReservationCalendarGetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function data(ReservationCalendarGetRequest $request)
    {
        return $this->response->make($this->service->data($request->all()));
    }
}
