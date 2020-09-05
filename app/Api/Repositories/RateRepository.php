<?php

namespace Api\Repositories;

use Api\Models\Rate;

/**
 * Class RateRepository
 * @package Api\Repositories
 */
class RateRepository extends BaseApiRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Rate::class;
    }
}
