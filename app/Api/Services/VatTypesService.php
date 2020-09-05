<?php

namespace Api\Services;

use Api\Filters\VatTypesFilter;
use Api\Models\VatType;
use Api\Repositories\VatTypesRepository;
use Api\Transformers\VatTypesTransformer;

/**
 * Class CompaniesService
 * @package Api\Services
 */
class VatTypesService extends BaseApiService
{
    /**
     * CompaniesService constructor.
     * @param VatTypesFilter $filter
     * @param VatTypesRepository $repository
     * @param VatTypesTransformer $transformer
     */
    public function __construct(
        VatTypesFilter $filter,
        VatTypesRepository $repository,
        VatTypesTransformer $transformer
    )
    {
        parent::__construct($filter, $repository, $transformer);
    }
}
