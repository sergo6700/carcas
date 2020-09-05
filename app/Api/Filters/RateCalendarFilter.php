<?php

namespace Api\Filters;

use Api\Repositories\Criterias\Core\SortCriteria;
use Api\Repositories\Criterias\Core\WhereInCriteria;

/**
 * Class RateCalendarFilter
 * @package Api\Filters\RateCalendar
 */
class RateCalendarFilter extends BaseApiFilter
{
    /**
     * @param $ids
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function filterByIds($ids)
    {
        $this->repository->pushCriteria(new WhereInCriteria('id', $ids));
    }

    /**
     * @param string $order
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByName($order = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('name', $order));
    }
}


