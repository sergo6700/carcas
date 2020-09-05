<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class DataController
 * @package Api\Http\Controllers
 */
class DataController extends Controller
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var DataService
     */
    protected $service;

    /**
     * DataController constructor.
     * @param Response $response
     * @param DataService $service
     */
    public function __construct(
        Response $response,
        DataService $service
    )
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function versions(Request $request)
    {
        return $this->response->make($this->service->versions($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function isoCountries2Letter(Request $request)
    {
        return $this->response->make($this->service->isoCountries2Letter($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function isoCountries3Letter(Request $request)
    {
        return $this->response->make($this->service->isoCountries3Letter($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function statTypes(Request $request)
    {
        return $this->response->make($this->service->statTypes($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function policeTypes(Request $request)
    {
        return $this->response->make($this->service->policeTypes($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function taxTypes(Request $request)
    {
        return $this->response->make($this->service->taxTypes($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function priceTypes(Request $request)
    {
        return $this->response->make($this->service->priceTypes($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function currencies(Request $request)
    {
        return $this->response->make($this->service->currencies($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function accommodations(Request $request)
    {
        return $this->response->make($this->service->accommodations($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function reservationDateTypes(Request $request)
    {
        return $this->response->make($this->service->reservationDateTypes($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function reservationStatuses(Request $request)
    {
        return $this->response->make($this->service->reservationStatuses($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function rateCalendarTypes(Request $request)
    {
        return $this->response->make($this->service->rateCalendarTypes($request->all()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function locale(Request $request)
    {
        return $this->response->make($this->service->locale($request->all()));
    }
}
