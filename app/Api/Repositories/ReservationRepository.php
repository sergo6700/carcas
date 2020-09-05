<?php

namespace Api\Repositories;

use Api\Models\Reservation;

/**
 * Class ReservationRepository
 * @package Api\Repositories
 */
class ReservationRepository extends BaseApiRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Reservation::class;
    }
}
