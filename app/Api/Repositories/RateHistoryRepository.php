<?php

namespace Api\Repositories;

use Api\Models\RateHistory;

/**
 * Class RateHistoryRepository
 * @package Api\Repositories
 */
class RateHistoryRepository extends BaseApiRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return RateHistory::class;
    }
}
