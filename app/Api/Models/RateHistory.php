<?php
namespace Api\Models;

/**
 * Class RateHistory
 * @package Api\Models
 */
class RateHistory extends BaseApiModel
{
    /**
     * @var string
     */
    protected $table = 'rates_history';

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
        'modification',
    ];
}
