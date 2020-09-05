<?php

namespace Api\Http\Middleware;

use Api\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;

/**
 * Class ApiProperties
 * @package Api\Http\Middleware
 */
class ApiProperties
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ApiProperties constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = auth()->user();
        $properties = [];

        if (!empty($user)) {
            $properties = $this->userRepository->getPropertyIds($user->id);
        }

        if (!defined('PROPERTY_IDS') && !empty($properties)) {
            define('PROPERTY_IDS', $properties);
        }

        return $next($request);
    }
}
