<?php

namespace Octorate\Core;

use GuzzleHttp\Exception\RequestException;
use Octorate\Contracts\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

/**
 * Class Response
 * @package Octorate\Core
 */
class Response implements ResponseInterface
{
    /**
     * @var PsrResponseInterface
     */
    private $_response;

    /**
     * @var RequestException
     */
    private $_exception;

    /**
     * @var bool
     */
    private $_success = false;

    /**
     * @var bool
     */
    private $_failure = false;

    /**
     * @var bool
     */
    private $_processed = false;

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->_success;
    }

    /**
     * @return bool
     */
    public function isFailure()
    {
        return $this->_failure;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function data()
    {
        if (!$this->_processed) {
            return null;
        }

        return $this->formatSuccess();
    }

    /**
     * @return array
     */
    public function errors()
    {
        if (!$this->_processed) {
            return null;
        }

        return $this->formatFailure();
    }

    /**
     * @return $this
     */
    public function resetInstance()
    {
        $this->_success = false;
        $this->_failure = false;
        $this->_processed = false;

        return $this;
    }

    /**
     * @param PsrResponseInterface $response
     * @return $this
     */
    public function success(PsrResponseInterface $response)
    {
        $this->resetInstance();

        $this->_success = true;
        $this->_response = $response;
        $this->_processed = true;

        return $this;
    }

    /**
     * @param RequestException $exception
     * @return $this
     */
    public function failure(RequestException $exception)
    {
        $this->resetInstance();

        $this->_failure = true;
        $this->_exception = $exception;
        $this->_processed = true;

        return $this;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function formatSuccess()
    {
        $body = $this->_response->getBody();

        return json_decode($body, true);
    }

    /**
     * @return array
     */
    protected function formatFailure()
    {
        $body = $this->_exception->getResponse()->getBody();
        $details = json_decode($body, true);

        return [
            'details' => $details,
            'code' => $this->_exception->getCode(),
        ];
    }
}
