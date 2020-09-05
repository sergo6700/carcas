<?php
namespace Api\Models;

/**
 * Class RoomType
 * @package Api\Models
 */
class RoomType extends BaseApiModel
{
    /**
     * @var string
     */
    protected $table = 'room_types';

    /**
     * @var array
     */
    protected $fillable = [
        'property_id',
        'unit_category_id',
        'name',
        'quantity',
        'adults',
        'children',
        'bathrooms',
        'min_price',
        'cfnd',
        'infants',
        'breakfast',
        'refundable',
        'min_stay',
        'max_stay',
        'is_child',
        'is_parent',
        'octorate_room_type_id',
    ];

    /**
     * @var array
     */
    protected $relations = [
        'rates',
        'property',
        'unit_category',
        'derivation_rules',
        'parent_derivation_rules',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit_category()
    {
        return $this->belongsTo(UnitCategory::class, 'unit_category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates()
    {
        return $this->hasMany(Rate::class, 'room_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function derivation_rules()
    {
        return $this->hasMany(DerivationRule::class, 'room_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parent_derivation_rules()
    {
        return $this->hasMany(DerivationRule::class, 'parent_id', 'id');
    }
}
