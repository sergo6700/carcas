<?php
namespace Api\Models;

/**
 * Class OctorateReservation
 * @package Api\Models
 */
class OctorateReservation extends BaseApiModel
{
    /**
     * @var string
     */
    protected $table = 'octorate_reservations';

    /**
     * @var array
     */
    protected $fillable = [
        'res_id',
        'source',
        'bbliverate_id',
        'bbliverate_date',
    ];
}
