<?php

namespace Secom;

/**
 * Class Secom
 * @package Secom
 */
class Secom
{
    /**
     * @var string
     */
    private $session;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Secom constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return array|mixed
     */
    public function createApiSession()
    {
        $response = $this->request->send('POST', "sessions", [
            'auth' => [
                config('secom.api_user'),
                config('secom.api_key')
            ]
        ]);

        if (200 === $response['code']) {
            $this->setSession($response['data']['id']);
        }

        return $response;
    }

    /**
     * @return array
     */
    public function getApiSession()
    {
        $session = $this->getSession();

        return $this->request->send('GET', "session/$session", [
            'auth' => [
                config('secom.api_user'),
                config('secom.api_key')
            ]
        ]);
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->request->send('POST', "/");
    }

    /**
     * @param array $data
     * @return array
     */
    public function createApiKey(array $data)
    {
        return $this->request->send('POST', "apikeys", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param $key
     * @return array
     */
    public function getApiKey($key)
    {
        return $this->request->send('GET', "apikey/$key", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param $key
     * @return array
     */
    public function deleteApiKey($key)
    {
        return $this->request->send('DELETE', "apikey/$key", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function addApiUser(array $data)
    {
        return $this->request->send('POST', "apiUsers", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param $apiUser
     * @return array
     */
    public function getApiUser($apiUser)
    {
        return $this->request->send('GET', "apiUser/$apiUser", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param $key
     * @param array $data
     * @return array
     */
    public function resetActivationApiUser($key, $data = [])
    {
        return $this->request->send('POST', "apiUsers/$key/resetActivation", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function addCard(array $data)
    {
        return $this->request->send('POST', "cards", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param $alias
     * @return array
     */
    public function getCard($alias)
    {
        return $this->request->send('GET', "card/$alias", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param $alias
     * @return array
     */
    public function getCardWithCVV($alias)
    {
        return $this->request->send('GET', "card/$alias/cvv", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param $alias
     * @return array|mixed
     */
    public function getMaskedCard($alias)
    {
        return $this->request->send('GET', "card/$alias/masked", [
            'headers' => $this->formatHeaders()
        ]);
    }

    /**
     * @param $alias
     * @return array|mixed
     */
    public function getCardDetails($alias)
    {
        return $this->request->send('GET', "card/$alias/details", [
            'headers' => $this->formatHeaders()
        ]);
    }

    /**
     * @param $alias
     * @return array
     */
    public function getCardHasCVV($alias)
    {
        return $this->request->send('GET', "card/$alias/hasCvv", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param $alias
     * @return array
     */
    public function getCardHasCVVDetailed($alias)
    {
        return $this->request->send('GET', "card/$alias/hasCvvDetailed", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param $alias
     * @return array
     */
    public function getCardSecondaryUser($alias)
    {
        return $this->request->send('GET', "card/$alias/secondaryUser", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @param $alias
     * @param array $data
     * @return array
     */
    public function setCardSecondaryUser($alias, array $data)
    {
        return $this->request->send('POST', "card/$alias/setSecondaryUser", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function addCardUI(array $data)
    {
        return $this->request->send('POST', "cards/addCardUI", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param $alias
     * @param array $data
     * @return array
     */
    public function getCardUI($alias, $data = [])
    {
        return $this->request->send('POST', "cardUI/$alias", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param $alias
     * @param array $data
     * @return array
     */
    public function getCardUIWithCVV($alias, $data = [])
    {
        return $this->request->send('POST', "cardUI/$alias/cvv", [
            'headers' => $this->formatHeaders(),
            'json' => $data
        ]);
    }

    /**
     * @param $alias
     * @return array
     */
    public function deleteCard($alias)
    {
        return $this->request->send('DELETE', "card/$alias", [
            'headers' => $this->formatHeaders(),
        ]);
    }

    /**
     * @return array
     */
    protected function formatHeaders()
    {
        return [
            'Ccs-Session' => $this->getSession(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }
}
