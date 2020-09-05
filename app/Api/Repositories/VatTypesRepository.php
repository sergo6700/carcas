<?php

namespace Api\Repositories;

use Api\Models\VatType;

/**
 * Class CompanyRepository
 * @package Api\Repositories
 */
class VatTypesRepository extends BaseApiRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return VatType::class;
    }

}
