<?php
namespace Api\Models;

/**
 * Class PropertyEmerchantToken
 * @package Api\Models
 */
class PropertyEmerchantToken extends BaseApiModel
{
    /**
     * @var string
     */
    protected $table = 'property_emerchant_tokens';

    /**
     * @var array
     */
    protected $fillable = [
        'property_id',
        'name',
        'token',
        'is_default'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}