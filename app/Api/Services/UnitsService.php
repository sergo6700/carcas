<?php

namespace Api\Services;

use Api\Filters\UnitFilter;
use Api\Repositories\Criterias\Core\WhereCriteria;
use Api\Repositories\ReservationRepository;
use Api\Repositories\UnitRepository;
use Api\Transformers\UnitTransformer;

/**
 * Class UnitsService
 * @package Api\Services
 */
class UnitsService extends BaseApiService
{
    /**
     * @var ReservationRepository
     */
    protected $reservationRepository;

    /**
     * UnitsService constructor.
     * @param UnitFilter $filter
     * @param UnitRepository $repository
     * @param UnitTransformer $transformer
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(
        UnitFilter $filter,
        UnitRepository $repository,
        UnitTransformer $transformer,
        ReservationRepository $reservationRepository
    )
    {
        parent::__construct($filter, $repository, $transformer);

        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @param $id
     * @param $startDate
     * @param $endDate
     * @return bool
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function isAvailable($id, $startDate, $endDate)
    {
        $endDate = carbon($endDate);
        $startDate = carbon($startDate);

        $this->reservationRepository->resetCriteria();
        $this->reservationRepository->pushCriteria(new WhereCriteria('unit_id', $id));
        $this->reservationRepository->pushCriteria(new WhereCriteria('end_date', $endDate->toDateString(), '>'));
        $this->reservationRepository->pushCriteria(new WhereCriteria('start_date', $startDate->toDateString(), '<'));
        $this->reservationRepository->pushCriteria(new WhereCriteria('status', \ConstReservationStatuses::CANCELED, '<>'));

        return !$this->reservationRepository->count();
    }
}
