<?php

namespace Api\Repositories;

use Api\Models\RoomType;

/**
 * Class RoomTypeRepository
 * @package Api\Repositories
 */
class RoomTypeRepository extends BaseApiRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return RoomType::class;
    }
}
