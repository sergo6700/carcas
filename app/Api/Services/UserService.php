<?php

namespace Api\Services;

use Api\Filters\UserFilter;
use Api\Repositories\UserRepository;
use Api\Transformers\UserTransformer;

/**
 * Class UserService
 * @package Api\Services
 */
class UserService extends BaseApiService
{
    /**
     * UserService constructor.
     * @param UserFilter $filter
     * @param UserRepository $repository
     * @param UserTransformer $transformer
     */
    public function __construct(
        UserFilter $filter,
        UserRepository $repository,
        UserTransformer $transformer
    )
    {
        parent::__construct($filter, $repository, $transformer);
    }
}
