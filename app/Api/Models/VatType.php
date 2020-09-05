<?php

/**
 * Class Company
 * @package Api\Models
 */
namespace Api\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;

class VatType extends BaseApiModel
{
    /**
     * @var string
     */
    protected $table = 'vat_types';

    /**
     * @var array
     */
    protected $fillable = [
        "name",
        "value",
    ];
    protected $relations = [
        'companies',
    ];

    /**
     * @return HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class, 'vat_type_id', 'id');
    }
}
