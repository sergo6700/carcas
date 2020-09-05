<?php

namespace Api\Services;

use Api\Filters\UserFilter;
use Api\Repositories\UserRepository;
use Api\Transformers\AuthUserTransformer;

/**
 * Class AuthService
 * @package Api\Services
 */
class AuthService extends BaseApiService
{
    /**
     * @var array
     */
    protected $authSelects = [
        'name',
        'email',
    ];

    /**
     * AuthService constructor.
     * @param UserFilter $filter
     * @param UserRepository $repository
     * @param AuthUserTransformer $transformer
     */
    public function __construct(
        UserFilter $filter,
        UserRepository $repository,
        AuthUserTransformer $transformer
    )
    {
        parent::__construct($filter, $repository, $transformer);
    }

    /**
     * @return array|mixed
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function auth()
    {
        return $this->single(auth()->id());
    }
}
