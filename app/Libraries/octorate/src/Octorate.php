<?php

namespace Octorate;

use Octorate\Core\Request;

/**
 * Class Octorate
 * @package Octorate
 */
class Octorate
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Octorate constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Core\Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAccommodations()
    {
        return $this->request->get("rest/accommodation");
    }

    /**
     * @param array $data
     * @return Core\Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function createAccommodation(array $data)
    {
        return $this->request->post("rest/accommodation", $data);
    }

    /**
     * @param $id
     * @param array $data
     * @return Core\Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function updateAccommodation($id, array $data)
    {
        return $this->request->patch("rest/accommodation/$id", $data);
    }

    /**
     * @param array $data
     * @return Core\Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function saveCalendarBulk(array $data)
    {
        return $this->request->post("rest/calendar/bulk", $data);
    }
}
