<?php

namespace Api\Services;

use Api\Filters\ReservationFilter;
use Api\Repositories\ReservationRepository;
use Api\Transformers\ReservationTransformer;

/**
 * Class ReservationsService
 * @package Api\Services
 */
class ReservationsService extends BaseApiService
{
    /**
     * ReservationsService constructor.
     * @param ReservationFilter $filter
     * @param ReservationRepository $repository
     * @param ReservationTransformer $transformer
     */
    public function __construct(
        ReservationFilter $filter,
        ReservationRepository $repository,
        ReservationTransformer $transformer
    )
    {
        parent::__construct($filter, $repository, $transformer);
    }
}
