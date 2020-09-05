<?php

namespace Api\Filters;

use Api\Repositories\Criterias\Core\LeftJoinCriteria;
use Api\Repositories\Criterias\Core\SortCriteria;
use Api\Repositories\Criterias\Core\WhereCriteria;
use Api\Repositories\Criterias\Reservations\SearchCriteria;
use Illuminate\Support\Arr;

/**
 * Class ReservationFilter
 * @package Api\Filters
 */
class ReservationFilter extends BaseApiFilter
{
    /**
     * @return bool
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function filterByDefault()
    {
        if (Arr::get($this->data, 'to') || Arr::get($this->data, 'from')) {
            return false;
        }

        $startDateField = Arr::get($this->data, 'date') ? $this->data['date'] : 'start_date';

        $this->repository->pushCriteria(new WhereCriteria($startDateField, today()->toDateString(), '>='));
    }

    /**
     * @param $id
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByClientId($id)
    {
        $this->repository->pushCriteria(new WhereCriteria('client_id', $id));
    }

    /**
     * @param $to
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function filterByTo($to)
    {
        $startDateField = Arr::get($this->data, 'date') ? $this->data['date'] : 'start_date';

        $this->repository->pushCriteria(new WhereCriteria($startDateField, carbon($to)->toDateString(), '<='));
    }

    /**
     * @param $from
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function filterByFrom($from)
    {
        $startDateField = Arr::get($this->data, 'date') ? $this->data['date'] : 'start_date';

        $this->repository->pushCriteria(new WhereCriteria($startDateField, carbon($from)->toDateString(), '>='));
    }

    /**
     * @param $status
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function filterByStatus($status)
    {
        $this->repository->pushCriteria(new WhereCriteria('status', $status));
    }

    /**
     * @param $search
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function filterBySearch($search)
    {
        $this->repository->pushCriteria(new SearchCriteria($search));
    }

    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByCreatedAt($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('created_at', $sort));
    }

    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByStartDate($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('start_date', $sort));
    }

    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByStatus($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('status', $sort));
    }

    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByUnit($sort = 'asc')
    {
        $this->repository->pushCriteria(new LeftJoinCriteria('units', 'id', 'unit_id'));
        $this->repository->pushCriteria(new SortCriteria('name', $sort, 'units'));
    }
}


