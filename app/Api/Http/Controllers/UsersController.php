<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Http\Controllers\Traits\ListableTrait;
use Api\Services\AuthService;
use Api\Services\UserService;

/**
 * Class UsersController
 * @package Api\Http\Controllers
 */
class UsersController extends BaseApiController
{
    use ListableTrait;

    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * UsersController constructor.
     * @param Response $response
     * @param UserService $service
     * @param AuthService $authService
     */
    public function __construct(
        Response $response,
        UserService $service,
        AuthService $authService
    )
    {
        parent::__construct($response, $service);

        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function auth()
    {
        return $this->response->make($this->authService->auth());
    }
}
