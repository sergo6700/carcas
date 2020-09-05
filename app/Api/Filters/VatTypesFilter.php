<?php

namespace Api\Filters;

use Api\Repositories\Criterias\Core\SortCriteria;
use Api\Repositories\Criterias\Main\ByCompanyCriteria;
use Api\Repositories\Criterias\Companies\SearchCriteria;

/**
 * Class CompanyFilter
 * @package Api\Filters
 */
class VatTypesFilter extends BaseApiFilter
{
    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByDefault()
    {
//        $this->repository->pushCriteria(new ByCompanyCriteria());
//        $this->repository->pushCriteria(new SortCriteria('name', 'asc'));
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
    protected function sortByName($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('name', $sort));
    }

    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByEmail($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('email', $sort));
    }

    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByPhone($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('phone', $sort));
    }

    /**
     * @param string $sort
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function sortByCountry($sort = 'asc')
    {
        $this->repository->pushCriteria(new SortCriteria('country', $sort));
    }

//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByCreatedAt($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('created_at', $sort));
//    }
//
//
//
//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByCustomerName($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('customer_name', $sort));
//    }
//
//
//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByState($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('state', $sort));
//    }
//
//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByCity($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('city', $sort));
//    }
//
//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByAddress($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('address', $sort));
//    }
//
//
//
//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByPostCode($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('post_code', $sort));
//    }
//
//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByVatCode($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('vat_code', $sort));
//    }
//
//    /**
//     * @param string $sort
//     * @throws \Prettus\Repository\Exceptions\RepositoryException
//     */
//    protected function sortByTaxCode($sort = 'asc')
//    {
//        $this->repository->pushCriteria(new SortCriteria('tax_code', $sort));
//    }

}


