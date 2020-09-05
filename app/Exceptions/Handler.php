<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Api\Core\Response\Response;
use Api\Core\Exceptions\AbstractHttpException;
use Api\Exceptions\AccessDeniedException;
use Api\Exceptions\BadRequestException;
use Api\Exceptions\NotFoundException;
use Api\Exceptions\ValidationException;
use Api\Exceptions\AuthenticationException as CoreAuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Handler constructor.
     * @param Container $container
     * @param Response $response
     */
    public function __construct(
        Container $container,
        Response $response
    )
    {
        parent::__construct($container);

        $this->response = $response;
    }

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api') !== false;
    }

    /**
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug') || !$this->isApiCall($request)) {
            return parent::render($request, $exception);
        }

        if ($exception instanceof IlluminateValidationException) {
            return $this->response->exception(new ValidationException($exception->validator));
        }

        if ($exception instanceof UnauthorizedException) {
            return $this->response->exception(new AccessDeniedException($exception->getMessage()));
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->response->exception(new NotFoundException());
        }

        if ($exception instanceof IlluminateAuthenticationException) {
            return $this->response->exception(new CoreAuthenticationException());
        }

        if ($exception instanceof AbstractHttpException) {
            return $this->response->exception($exception);
        }

        return $this->response->exception(new BadRequestException($exception->getMessage()));
    }

}
