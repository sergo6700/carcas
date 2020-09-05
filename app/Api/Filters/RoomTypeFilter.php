<?php

namespace Api\Filters;

use Api\Repositories\Criterias\Core\SortCriteria;

/**
 * Class RoomTypeFilter
 * @package Api\Filters
 */
class RoomTypeFilter extends BaseApiFilter
{
    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByName($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('name', $sort));
    }
}
