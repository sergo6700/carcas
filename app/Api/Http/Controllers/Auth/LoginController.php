<?php

namespace Api\Http\Controllers\Auth;

use Api\Auth\Traits\OAuthProxy;
use Api\Http\Controllers\BaseApiController;
use Api\Responses\AuthResponse;
use Api\Services\AuthService;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class LoginController
 * @package Api\Http\Controllers\Auth
 */
class LoginController extends BaseApiController
{
    use ThrottlesLogins, OAuthProxy;

    /**
     * LoginController constructor.
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
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        $response = $this->attemptLogin($request);
        if ($response) {
            return $this->response->make($response);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse();
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $this->guard()->user()->token()->revoke();
        } catch (\Exception $e) {

        }

        return response(null, 200);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|bool
     */
    protected function attemptLogin(Request $request)
    {
        try {
            return $this->proxy('password', [
                'username' => $request->input($this->username()),
                'password' => $request->input('password')
            ]);
        } catch (HttpException $e) {

        }

        return false;
    }

    /**
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => ['Invalid credentials!'],
        ]);
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * @return string
     */
    protected function username()
    {
        return 'email';
    }
}
