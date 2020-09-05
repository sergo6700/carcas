<?php

namespace Secom;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Secom\Events\RequestFailed;

/**
 * Class Request
 * @package Secom
 */
class Request
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Secom constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->getBaseUri()
        ]);
    }

    /**
     * @param string $method
     * @param $endPoint
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\GuzzleException
     */
    public function send($method = 'POST', $endPoint, $data = [])
    {
        try {
            $response = $this->client->request($method, $endPoint, $data);
        } catch (RequestException $exception) {
            event(new RequestFailed([
                'exception' => $exception
            ]));

            return [
                'code' => $exception->getCode(),
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ];
        }

        return [
            'code' => $response->getStatusCode(),
            'data' => $this->formatResponse($response),
        ];
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    protected function formatResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody(), true);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function getBaseUri()
    {
        if (config('app.env') === 'local') {
            return config('secom.test_uri');
        }

        return config('secom.production_uri');
    }
}
