<?php

namespace Api\Http\Controllers\Auth;

use Api\Auth\Traits\OAuthProxy;
use Api\Http\Controllers\BaseApiController;
use Api\Responses\AuthResponse;
use Api\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class RefreshController
 * @package Api\Http\Controllers\Auth
 */
class RefreshController extends BaseApiController
{
    use OAuthProxy;

    /**
     * RefreshController constructor.
     * @param AuthResponse $response
     * @param AuthService $service
     */
    public function __construct(
        AuthResponse $response,
        AuthService $service
    )
    {
        parent::__construct($response, $service);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function refresh(Request $request)
    {
        $this->validateRefresh($request);

        $response = $this->attemptRefresh($request);

        if ($response) {
            return $this->response->make($response);
        }

        $this->sendFailedRefreshResponse();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function attemptRefresh(Request $request)
    {
        try {
            return $this->proxy('refresh_token', [
                'refresh_token' => $request->input('refreshToken')
            ]);
        } catch (HttpException $exception) {

        }
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function validateRefresh(Request $request)
    {
        $this->validate($request, [
            'refreshToken' => 'required|string'
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function sendFailedRefreshResponse()
    {
        throw ValidationException::withMessages([
            'refreshToken' => 'Refresh Failed'
        ]);
    }
}
