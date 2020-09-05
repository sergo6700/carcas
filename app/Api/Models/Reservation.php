<?php
namespace Api\Models;

/**
 * Class Reservation
 * @package Api\Models
 */
class Reservation extends BaseApiModel
{
    /**
     * @var string
     */
    protected $table = 'reservations';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'property_id',
        'room_type_id',
        'client_id',
        'unit_id',
        'octorate_reservation_id',
        'res_id',
        'status',
        'start_date',
        'end_date',
        'amount',
        'city_tax',
        'ota_fee',
        'currency',
        'source',
        'arrival_time',
        'adults',
        'children',
        'infants',
        'is_ciaobooking',
        'is_paid',
        'is_refundable',
        'ccs_token',
        'ccs_prepaid',
        'ccs_brand',
        'ccs_bank',
        'ccs_scheme',
        'ccs_type',
        'ccs_expire_date',
        'ccs_pan',
        'ccs_card_holder',
        'ota_note',
        'internal_note',
        'service_note',
    ];

    /**
     * @var array
     */
    protected $relations = [
        'client',
        'unit',
        'property',
        'room_type',
        'octorate_reservation',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room_type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function octorate_reservation()
    {
        return $this->hasOne(OctorateReservation::class, 'id', 'octorate_reservation_id');
    }
}
