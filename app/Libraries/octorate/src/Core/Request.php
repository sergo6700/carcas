<?php

namespace Octorate\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Octorate\Contracts\RequestInterface;

/**
 * Class Request
 * @package Octorate\Core
 */
class Request implements RequestInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Request constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;

        $this->client = new Client([
            'verify' => false,
            'base_uri' => Constants::BASE_URL
        ]);
    }

    /**
     * @param $endPoint
     * @param array $params
     * @param array $headers
     * @return Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function get($endPoint, $params = [], $headers = [])
    {
        return $this->send('GET', $endPoint, $params, $headers);
    }

    /**
     * @param $endPoint
     * @param array $params
     * @param array $headers
     * @return Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function post($endPoint, $params = [], $headers = [])
    {
        if (!empty($params)) {
            $params = [
                'json' => $params
            ];
        }

        return $this->send('POST', $endPoint, $params, $headers);
    }

    /**
     * @param $endPoint
     * @param array $params
     * @param array $headers
     * @return Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function put($endPoint, $params = [], $headers = [])
    {
        if (!empty($params)) {
            $params = [
                'json' => $params
            ];
        }

        return $this->send('PUT', $endPoint, $params, $headers);
    }

    /**
     * @param $endPoint
     * @param array $params
     * @param array $headers
     * @return Response
     * @throws \GuzzleHttp\GuzzleException
     */
    public function patch($endPoint, $params = [], $headers = [])
    {
        if (!empty($params)) {
            $params = [
                'json' => $params
            ];
        }

        return $this->send('PATCH', $endPoint, $params, $headers);
    }

    /**
     * @param $method
     * @param $endPoint
     * @param array $params
     * @param array $headers
     * @return Response
     * @throws \GuzzleHttp\GuzzleException
     */
    protected function send($method, $endPoint, $params = [], $headers = [])
    {
        $params['headers'] = $this->mergeHeaders($headers);

        $endPoint = trim($endPoint, '/');

        try {
            $response = $this->client->request($method, $endPoint, $params);

            return $this->response->success($response);
        } catch (RequestException $exception) {
            return $this->response->failure($exception);
        }
    }

    /**
     * @param array $headers
     * @return array
     */
    protected function mergeHeaders(array $headers)
    {
        return array_merge([
            'key' => config('octorate.api_key'),
            'Content-Type' => 'application/json'
        ], $headers);
    }
}
