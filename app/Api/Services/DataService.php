<?php

namespace Api\Services;

use PragmaRX\Countries\Package\Countries;
use App;

/**
 * Class DataService
 * @package Api\Services
 */
class DataService
{
    /**
     * @var Countries
     */
    protected $pragmaCountries;

    /**
     * DataService constructor.
     * @param Countries $countries
     */
    public function __construct(Countries $countries)
    {
        $this->pragmaCountries = $countries;
    }

    /**
     * @param array $data
     * @return array
     */
    public function isoCountries2Letter(array $data)
    {
        return iso_countries_2_letters();
    }

    /**
     * @param array $data
     * @return array
     */
    public function isoCountries3Letter(array $data)
    {
        return iso_countries_3_letters();
    }

    /**
     * @param array $data
     * @return array
     */
    public function statTypes(array $data)
    {
        return parse_to_key_value(config('chekin.stat_types'));
    }

    /**
     * @param array $data
     * @return array
     */
    public function policeTypes(array $data)
    {
        return parse_to_key_value(config('chekin.police_types'));
    }

    /**
     * @param array $data
     * @return array
     */
    public function taxTypes(array $data)
    {
        return [
            [
                'id' => \ConstCityTaxType::FIXED_AMOUNT,
                "name" => trans('properties.city_tax_type.fixed_amount')
            ],
            [
                'id' => \ConstCityTaxType::PERCENTAGE,
                "name" => trans('properties.city_tax_type.percentage')
            ],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function priceTypes(array $data)
    {
        return [
            [
                'id' => \ConstPriceCorrectionType::PERCENTAGE,
                "name" => trans('properties.price_correction_type.percentage')
            ],
            [
                'id' => \ConstPriceCorrectionType::FIXED,
                "name" => trans('properties.price_correction_type.fixed')
            ],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function versions(array $data)
    {
        return [
            [
                'id' => \ConstCiaoBookingVersions::V1,
                'name' => 'V1',
            ],
            [
                'id' => \ConstCiaoBookingVersions::V2,
                'name' => 'V2',
            ],
            [
                'id' => \ConstCiaoBookingVersions::V3,
                'name' => 'V3',
            ],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function currencies(array $data)
    {
        $currencies = $this->pragmaCountries
            ->currencies()
            ->toArray();

        return array_keys($currencies);
    }

    /**
     * @param array $data
     * @return array
     */
    public function accommodations(array $data)
    {
        return array_values(trans('properties.accommodation_types'));
    }

    /**
     * @param array $data
     * @return array
     */
    public function reservationDateTypes(array $data)
    {
        return [
            [
                'id' => 'end_date',
                "name" => trans('reservations.filters.date_types.end_date')
            ],
            [
                'id' => 'start_date',
                "name" => trans('reservations.filters.date_types.start_date')
            ],
            [
                'id' => 'created_at',
                "name" => trans('reservations.filters.date_types.created_at')
            ],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function reservationStatuses(array $data)
    {
        return [
            [
                'id' => \ConstReservationStatuses::PENDING,
                "name" => trans('reservations.statuses.' . \ConstReservationStatuses::PENDING)
            ],
            [
                'id' => \ConstReservationStatuses::CANCELED,
                "name" => trans('reservations.statuses.' . \ConstReservationStatuses::CANCELED)
            ],
            [
                'id' => \ConstReservationStatuses::UPDATE,
                "name" => trans('reservations.statuses.' . \ConstReservationStatuses::UPDATE)
            ],
            [
                'id' => \ConstReservationStatuses::COMPLETED,
                "name" => trans('reservations.statuses.' . \ConstReservationStatuses::COMPLETED)
            ],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function rateCalendarTypes(array $data)
    {
        return [
            [
                'id' => \ConstRateCalendarTypes::DETAILED,
                "name" => trans('rate-calendar.types.' . \ConstRateCalendarTypes::DETAILED)
            ],
            [
                'id' => \ConstRateCalendarTypes::COMPRESSED,
                "name" => trans('rate-calendar.types.' . \ConstRateCalendarTypes::COMPRESSED)
            ],
        ];
    }

    /**
     * @return array
     */
    public function locale(array $data)
    {
        return config('app.locales');
    }
}
