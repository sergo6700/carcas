<?php
namespace Api\Models;

/**
 * Class Rate
 * @package Api\Models
 */
class Rate extends BaseApiModel
{
    /**
     * @var string
     */
    protected $table = 'rates';

    /**
     * @var array
     */
    protected $fillable = [
        'room_type_id',
        'date',
        'amount',
        'availability',
        'min_stay',
        'max_stay',
        'cta',
        'ctd',
        'stop_sell',
        'cut_off',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room_type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }
}
